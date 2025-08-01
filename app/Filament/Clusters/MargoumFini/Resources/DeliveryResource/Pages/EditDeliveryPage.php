<?php

namespace App\Filament\Clusters\MargoumFini\Resources\DeliveryResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\DeliveryResource;
use App\Models\Delivery;
use App\Models\Client;
use App\Models\Employees;
use App\Models\Depot;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class EditDeliveryPage extends Page
{
    protected static string $resource = DeliveryResource::class;
    protected static string $view = 'filament.resources.delivery-resource.pages.edit-delivery-page';

    public Delivery $delivery;
    public Collection $clients;
    public Collection $employees;
    public Collection $depots;
    public array $scannedPackages = [];
    public string $bnlNumber;

    public function mount($record)
    {
        $this->delivery = Delivery::with(['items.package.product', 'items.package.depot'])
            ->findOrFail($record);
            
        if ($this->delivery->status !== 'Draft') {
            abort(403, 'You can only edit deliveries in Draft status');
        }

        $this->clients = Client::all();
        $this->employees = Employees::all();
        $this->depots = Depot::all();
        $this->bnlNumber = 'BNL-' . $this->delivery->id;

        $this->scannedPackages = $this->delivery->items
            ->map(function ($item) {
                return [
                    'qr_code' => $item->package->qr_code,
                    'product' => [
                        'code_article' => $item->package->product->code_article,
                    ],
                    'quantity' => $item->package->quantity,
                    'depot' => [
                        'name' => $item->package->depot->name ?? 'N/A',
                    ],
                ];
            })
            ->toArray();
    }
}