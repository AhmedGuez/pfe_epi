<?php

namespace App\Filament\Clusters\MargoumFini\Resources\DeliveryResource\Pages;


use App\Models\Delivery;
use App\Models\Package;
use App\Models\StockMovement;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Clusters\MargoumFini\Resources\DeliveryResource;
use App\Models\Client;
use App\Models\Depot;
use App\Models\Employees;

class DeliveryPage extends Page
{
       
    protected static string $resource = DeliveryResource::class;

    protected static string $view = 'filament.resources.delivery-resource.pages.delivery-page';

    public $client_name;
    public $car_number;
    public $delivery_date;
    public $scannedPackages = [];

    protected $rules = [
        'client_name' => 'required|string|max:255',
        'car_number' => 'required|string|max:255',
        'delivery_date' => 'required|date',
        'scannedPackages' => 'required|array|min:1',
    ];

    public $clients;
    public $employees;
    public $depots;
     public $lastId;
    public $Delivery;

    public string $bnlNumber;

    public function mount()
    {
        $this->lastId = Delivery::max('id') ?? 0;
        $this->clients = Client::all();
        $this->employees = Employees::all();
        $this->depots = Depot::all();
    }
    
}
