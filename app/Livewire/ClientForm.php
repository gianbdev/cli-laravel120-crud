<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;

class ClientForm extends Component
{
    public $client_id;
    public $clients = []; // ✅ aseguramos que sea array
    public $name, $email, $phone, $address;
    public $showForm = false;

    public function render()
    {
        return view('livewire.client-form');
    }

    public function mount()
    {
        $this->getClients();
    }

    public function getClients()
    {
        $this->clients = Client::all();
    }

    public function store()
    {
        $this->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:clients,email,' . $this->client_id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Client::updateOrCreate(
            ['id' => $this->client_id],
            ['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone, 'address' => $this->address]
        );

        $this->resetForm();
        $this->getClients();
        $this->showForm = false; // ocultamos el modal al guardar
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $this->client_id = $client->id;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->address = $client->address;

        $this->showForm = true; // 👉 Mostrar el formulario flotante2
    }

    public function delete($id)
    {
        Client::destroy($id);
        $this->getClients();
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'address', 'client_id']);
    }

    public function resetFormAndShow()
    {
        $this->resetForm();
        $this->showForm = !$this->showForm;
    }
}
