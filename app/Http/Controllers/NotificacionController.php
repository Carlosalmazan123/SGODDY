<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class NotificacionController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}
    //
    public function marcarLeida($id)
    {
        $notificacion = auth()->user()->notifications()->find($id);
        if ($notificacion) {
            $notificacion->markAsRead();
        }
        return redirect()->route("tickets.inicio");
    }

    public function marcarTodasLeidas()
    {
      
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back(); 
    }
}
