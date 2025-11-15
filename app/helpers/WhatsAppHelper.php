<?php
/**
 * WhatsApp Helper - Integración con WhatsApp Business API
 * Requiere configurar credenciales de Twilio o similar
 */
class WhatsAppHelper {
    private $apiUrl;
    private $accountSid;
    private $authToken;
    private $fromNumber;

    public function __construct() {
        // Configuración de Twilio WhatsApp (ejemplo)
        $this->apiUrl = 'https://api.twilio.com/2010-04-01';
        $this->accountSid = getenv('TWILIO_ACCOUNT_SID') ?: 'YOUR_ACCOUNT_SID';
        $this->authToken = getenv('TWILIO_AUTH_TOKEN') ?: 'YOUR_AUTH_TOKEN';
        $this->fromNumber = getenv('TWILIO_WHATSAPP_NUMBER') ?: 'whatsapp:+14155238886';
    }

    /**
     * Enviar mensaje de WhatsApp
     */
    public function sendMessage($to, $message, $mediaUrl = null) {
        $url = "{$this->apiUrl}/Accounts/{$this->accountSid}/Messages.json";

        // Formatear número para WhatsApp
        $toNumber = $this->formatWhatsAppNumber($to);

        $data = [
            'From' => $this->fromNumber,
            'To' => $toNumber,
            'Body' => $message
        ];

        if ($mediaUrl) {
            $data['MediaUrl'] = $mediaUrl;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->accountSid}:{$this->authToken}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($httpCode === 201) {
            return [
                'success' => true,
                'message_sid' => $result['sid'] ?? null,
                'status' => $result['status'] ?? 'sent'
            ];
        } else {
            return [
                'success' => false,
                'error' => $result['message'] ?? 'Error al enviar mensaje',
                'code' => $result['code'] ?? $httpCode
            ];
        }
    }

    /**
     * Enviar recordatorio de cita
     */
    public function sendAppointmentReminder($appointment, $patient) {
        $date = date('d/m/Y', strtotime($appointment['appointment_date']));
        $time = date('H:i', strtotime($appointment['start_time']));

        $message = "🦷 *INNOVADENT - Recordatorio de Cita*\n\n";
        $message .= "Hola {$patient['first_name']},\n\n";
        $message .= "Te recordamos tu cita:\n";
        $message .= "📅 Fecha: {$date}\n";
        $message .= "🕐 Hora: {$time}\n";
        $message .= "👨‍⚕️ Doctor: {$appointment['doctor_first_name']} {$appointment['doctor_last_name']}\n\n";
        $message .= "Si necesitas reagendar, contáctanos.\n\n";
        $message .= "¡Te esperamos! 😊";

        return $this->sendMessage($patient['phone'], $message);
    }

    /**
     * Enviar confirmación de cita
     */
    public function sendAppointmentConfirmation($appointment, $patient) {
        $date = date('d/m/Y', strtotime($appointment['appointment_date']));
        $time = date('H:i', strtotime($appointment['start_time']));

        $message = "✅ *Cita Confirmada - INNOVADENT*\n\n";
        $message .= "Hola {$patient['first_name']},\n\n";
        $message .= "Tu cita ha sido confirmada:\n";
        $message .= "📅 {$date} a las {$time}\n\n";
        $message .= "Nos vemos pronto! 🦷";

        return $this->sendMessage($patient['phone'], $message);
    }

    /**
     * Enviar mensaje de cumpleaños
     */
    public function sendBirthdayMessage($patient) {
        $message = "🎉 *¡Feliz Cumpleaños!* 🎂\n\n";
        $message .= "Hola {$patient['first_name']},\n\n";
        $message .= "Todo el equipo de INNOVADENT te desea un feliz cumpleaños!\n\n";
        $message .= "Que tengas un día maravilloso! 😊🎈";

        return $this->sendMessage($patient['phone'], $message);
    }

    /**
     * Enviar campaña promocional
     */
    public function sendPromotion($patients, $message) {
        $results = [];

        foreach ($patients as $patient) {
            if (!empty($patient['phone'])) {
                $personalizedMessage = str_replace(
                    '{nombre}',
                    $patient['first_name'],
                    $message
                );

                $result = $this->sendMessage($patient['phone'], $personalizedMessage);
                $results[] = [
                    'patient_id' => $patient['id'],
                    'success' => $result['success']
                ];

                // Delay para no saturar API
                usleep(500000); // 0.5 segundos
            }
        }

        return $results;
    }

    /**
     * Formatear número para WhatsApp
     */
    private function formatWhatsAppNumber($number) {
        // Remover caracteres no numéricos
        $number = preg_replace('/[^0-9]/', '', $number);

        // Agregar código de país si no existe (asumiendo México +52)
        if (strlen($number) === 10) {
            $number = '52' . $number;
        }

        return 'whatsapp:+' . $number;
    }

    /**
     * Verificar estado de mensaje
     */
    public function getMessageStatus($messageSid) {
        $url = "{$this->apiUrl}/Accounts/{$this->accountSid}/Messages/{$messageSid}.json";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->accountSid}:{$this->authToken}");

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        return [
            'status' => $result['status'] ?? 'unknown',
            'error_code' => $result['error_code'] ?? null,
            'error_message' => $result['error_message'] ?? null
        ];
    }
}
