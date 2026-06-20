<?php

require_once __DIR__ . '/../../config/mercadopago.php';

class MercadoPagoService
{
    private string $token;
    private string $apiBase = 'https://api.mercadopago.com';

    public function __construct()
    {
        $this->token = MP_ACCESS_TOKEN;
    }

    /**
     * Crea una preferencia de pago en Mercado Pago.
     * Retorna el array de la preferencia o lanza una excepción si falla.
     */
    public function crearPreferencia(array $params): array
    {
        $payload = [
            'items' => [[
                'id'          => $params['id'],
                'title'       => $params['titulo'],
                'quantity'    => 1,
                'unit_price'  => (float) $params['monto'],
                'currency_id' => 'ARS',
            ]],
            'back_urls' => [
                'success' => $params['url_exito'],
                'failure' => $params['url_error'],
                'pending' => $params['url_pendiente'],
            ],
            'auto_return'        => 'approved',
            'external_reference' => (string) $params['referencia_externa'],
            'statement_descriptor' => 'Malku Gift Card',
        ];

        $response = $this->post('/checkout/preferences', $payload);

        if (empty($response['id'])) {
            throw new RuntimeException('No se pudo crear la preferencia de pago en Mercado Pago.');
        }

        return $response;
    }

    /**
     * Consulta un pago por su ID y devuelve los datos.
     * Retorna null si no se puede obtener el pago.
     */
    public function obtenerPago(string $paymentId): ?array
    {
        $response = $this->get("/v1/payments/{$paymentId}");

        if (empty($response['id'])) {
            return null;
        }

        return $response;
    }

    /**
     * Verifica que un pago esté aprobado y corresponda a la referencia dada.
     */
    public function verificarPagoAprobado(string $paymentId, string $referenciaEsperada): bool
    {
        $pago = $this->obtenerPago($paymentId);

        if (!$pago) {
            return false;
        }

        return $pago['status'] === 'approved'
            && (string) $pago['external_reference'] === $referenciaEsperada;
    }

    // ── Helpers HTTP ──────────────────────────────────────────────────

    private function post(string $endpoint, array $data): array
    {
        return $this->request('POST', $endpoint, $data);
    }

    private function get(string $endpoint): array
    {
        return $this->request('GET', $endpoint);
    }

    private function request(string $method, string $endpoint, array $data = []): array
    {
        $ch = curl_init($this->apiBase . $endpoint);

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token,
        ];

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $result   = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("MercadoPagoService cURL error: {$error}");
            return [];
        }

        $decoded = json_decode($result, true);
        return is_array($decoded) ? $decoded : [];
    }
}
