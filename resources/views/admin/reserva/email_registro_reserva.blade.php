<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Confirmada</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #2c3e50;
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .header .subtitle {
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
            background: white;
        }
        .welcome-message {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
        .status-message {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
            font-size: 16px;
        }
        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            border-left: 5px solid #667eea;
        }
        .info-row {
            display: flex;
            gap: 8px;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #2c3e50;
            font-weight: 600;
        }
        .info-value {
            color: #666;
            font-weight: 400;
        }
        .qr-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 30px;
            margin: 25px 0;
            text-align: center;
            border: 2px solid #667eea;
        }
        .qr-section h3 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 20px;
        }
        .qr-section p {
            color: #666;
            margin-bottom: 20px;
        }
        .qr-wrapper {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .qr-wrapper img {
            width: 200px;
            height: 200px;
            display: block;
        }
        .reminder-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
        }
        .reminder-box strong {
            color: #856404;
            display: block;
            margin-bottom: 8px;
        }
        .reminder-box p {
            color: #856404;
            margin: 0;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .footer p {
            margin: 10px 0;
            opacity: 0.8;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 15px;
            }
            .header, .content, .footer {
                padding: 20px;
            }
            .welcome-message {
                font-size: 20px;
            }
            .info-row {
                flex-direction: column;
                gap: 5px;
            }
            .info-value {
                text-align: left;
            }
            .qr-wrapper img {
                width: 180px;
                height: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>PUKARA SPORTS</h1>
            <div class="subtitle">Gestión Inteligente de Espacios Deportivos</div>
        </div>
        
        <div class="content">
            <div class="welcome-message">
                ¡Hola {{ $reserva->deportista->user->nombres }}!
            </div>
            <p class="status-message">
                Tu reserva ha sido registrada exitosamente. A continuación encontrarás todos los detalles y el código QR que puedes compartir con tus amigos para que se unan como participantes.
            </p>
            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">Espacio Deportivo:</span>
                    <span class="info-value">{{ $reserva->cancha->espacioDeportivo->nombre }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ubicación:</span>
                    <span class="info-value">{{ $reserva->cancha->espacioDeportivo->direccion }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Cancha:</span>
                    <span class="info-value">{{ $reserva->cancha->nombre }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($reserva->fechaReserva)->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Horario:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($reserva->horaInicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->horaFin)->format('H:i') }}</span>
                </div>
            </div>
            
            <div class="qr-section">
                <h3>Código de Acceso</h3>
                <p>Presenta este código QR en la entrada</p>
                <div class="qr-wrapper">
                    @if($reserva->codigoQr && $reserva->codigoQr->qrimage)
                        <img src="{{ $message->embed(asset('storage/' . $reserva->codigoQr->qrimage)) }}" alt="Código QR de la Reserva">
                    @else
                        <p>No se ha generado un código QR para esta reserva.</p>
                    @endif
                </div>
            </div>
            
            <div class="reminder-box">
                <strong>Importante:</strong>
                <p>Por favor llega 10 minutos antes de tu horario reservado y presenta este código QR al personal de control para poder ingresar.</p>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Sistema de Reservas de Espacios Deportivos</strong></p>
            <p>Gestión inteligente y segura de espacios deportivos</p>
            <p style="font-size: 12px; margin-top: 15px;">
                Si tienes alguna consulta, no dudes en contactarnos.
            </p>
        </div>
    </div>
</body>
</html>