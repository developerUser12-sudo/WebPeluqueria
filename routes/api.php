<?php
use App\Http\Controllers\WhatsappController;
Route::post('/webhook/whatsapp', [WhatsappController::class, 'recibir']);
?>