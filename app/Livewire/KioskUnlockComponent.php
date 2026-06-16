<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KioskUnlockComponent extends Component
{
    public ?string $password = '';
    
    public function unlock()
    {
        $this->validate([
            'password' => 'required',
        ]);
        
        if (Hash::check($this->password, Auth::user()->password)) {
            // Eliminar la etiqueta de Kiosko para conceder acceso completo
            session()->forget('kiosk_mode');
            
            // Redirigir a la URL que intentaban visitar, o a inicio
            return redirect()->intended(route('inicio'));
        }
        
        $this->addError('password', __('La contraseña es incorrecta.'));
    }
    
    public function forgotPassword()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('password.request');
    }

    public function render()
    {
        return view('livewire.kiosk-unlock-component')->layout('layouts.guest');
    }
}
