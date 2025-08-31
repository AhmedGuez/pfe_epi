<?php

use App\Http\Controllers\ArivageController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BneMatierePremiereController;
use App\Http\Controllers\BnlController;
use App\Http\Controllers\BnsController;
use App\Http\Controllers\BnsDechetController;
use App\Http\Controllers\BnsRetourBobineController;
use App\Http\Controllers\BnsStockMargoumController;
use App\Http\Controllers\ClientUserController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommandePrintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DownloadBnsBobine;
use App\Http\Controllers\DownloadBnsBobineSr;
use App\Http\Controllers\DownloadCommande;
use App\Http\Controllers\FrangePayementController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Margoum2emeFiniController;
use App\Http\Controllers\MargoumFiniController;
use App\Http\Controllers\MarkAttendanceController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageInfoController;
use App\Http\Controllers\PackageStickerController;
use App\Http\Controllers\PackageTicketController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\QRCodeAttendanceController;
use App\Http\Controllers\QuestionaireController;
use App\Http\Controllers\SousTraitanceController;
use App\Http\Controllers\Stat\MargoumStatisticsController;
use App\Http\Controllers\Stat\RawMaterialStatsController;
use App\Http\Controllers\Stat\StockStatsController;
use App\Http\Controllers\Stat\SuiviStockRebobinageStatsController;
use App\Http\Controllers\Stock;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SuiviCommande;
use App\Http\Controllers\TransactionController;
use App\Livewire\DeliveryPOS;
use App\Models\Delivery;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/{record}/pdf',[DownloadBnsBobine::class,'downloadBnsBobine'])->name('bonSortie.pdf.download');
// Route::get('/{record}/reste-bobine',[BnsRetourBobineController::class,'downloadBnsResteBobine'])->name('bnsResteBobine');
// Route::get('/{record}/bns/pdf',[DownloadBnsBobineSr::class,'downloadBnsBobineSr'])->name('bonSortieBobineSr.pdf.download');
// Route::get('/{record}/bns/stock/margoum/pdf',[BnsStockMargoumController::class,'downloadBnsStockMargoum'])->name('bnsStockMargoum.pdf.download');
// Route::get('/{record}/bnl/pdf',[BnlController::class,'downloadBnl'])->name('bnl.pdf.download');
// Route::get('/{record}/bns/margoum/pdf',[BnsController::class,'downloadBnsMargoumSf'])->name('bnsMargoumSf.pdf.download');
Route::get('/{record}/commande/pdf',[DownloadCommande::class,'downloadCommande'])->name('commande.pdf.download');
Route::get('/{record}/Jrcommande/pdf',[DownloadCommande::class,'downloadJrCommande'])->name('Jrcommande.pdf.download');
Route::get('/commande/{commande}/print', [CommandePrintController::class, 'print'])->name('commande.print');
// Route::get('/list',[DownloadCommande::class,'downloadList'])->name('list.download.pdf');
Route::get('/{record}/suivi',[SuiviCommande::class,'downloadSuivi'])->name('suivi.pdf.download');
Route::get('/stock',[StockController::class,'Stock'])->name('stock.download.pdf');
// Route::get('/stock-tapis',[StockController::class,'StockTapis'])->name('stock.download.pdf.tapis');

Route::get('/stocks', [Stock::class, 'index'])->name('stocks.index');



// Route::get('/raw-materials/factory-quantity', [RawMaterialStatsController::class, 'factoryQuantity'])->name('raw-materials.factory-quantity');
// Route::get('/stock/quantity-over-time', [StockStatsController::class, 'quantityOverTime'])->name('stock.quantity-over-time');
// Route::get('/suivi-stock-rebobinage-stats', [SuiviStockRebobinageStatsController::class, 'showStats'])->name('showStats');

// Route::get('/margoum-statistics', [MargoumStatisticsController::class, 'ordersOverTime'])->name('margoum.statistics');

// Route::get('/{record}/design/dowlnload',[DownloadCommande::class,'downloadDesign'])->name('design.download');
// Route::get('/production-report', [ProductionController::class, 'showProductionDataByDate'])->name('production');
// Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
// Route::get('/dashboard-tapis', [DashboardController::class, 'dashboardTapis'])->name('dashboard.tapis');

// Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');

Route::get('/margoum-stock', [StockController::class, 'showStock'])->name('stock.show');

// Route::get('/margoum_fini', [MargoumFiniController::class, 'index'])->name('margoum_fini.index');
// Route::get('/margoum_fini_2eme', [Margoum2emeFiniController::class, 'index'])->name('margoum_fini.secondChoix');

// Route::get('/stats', [BneMatierePremiereController::class, 'filterStats'])->name('stats');
// Route::post('/stats', [BneMatierePremiereController::class, 'filterStats'])->name('filterStats');

Route::get('/home', [IndexController::class, 'index'])->name('home');
Route::get('/latest-arrivages', [ArivageController::class, 'index'])->name('latest-arrivages');

// Client-User Management Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('client-users')->group(function () {
        Route::post('/{client}/attach', [ClientUserController::class, 'attachUser'])->name('client-users.attach');
        Route::delete('/{client}/detach', [ClientUserController::class, 'detachUser'])->name('client-users.detach');
        Route::put('/{client}/update-role', [ClientUserController::class, 'updateUserRole'])->name('client-users.update-role');
        Route::get('/{client}/users', [ClientUserController::class, 'getClientUsers'])->name('client-users.get-users');
        Route::get('/my-clients', [ClientUserController::class, 'getUserClients'])->name('client-users.my-clients');
        Route::put('/{client}/set-primary', [ClientUserController::class, 'setPrimaryUser'])->name('client-users.set-primary');
    });
});


Route::get('/{record}/file/dowlnload',[DownloadCommande::class,'downloadFile'])->name('demande.download');
Route::get('/{record}/questionaire/dowlnload',[DownloadCommande::class,'downloadquestionaire'])->name('questionaire.download');

// Route::get('/sous-traitance/{record}', [SousTraitanceController::class, 'showSousTraitanceDetails'])
    // ->name('sous_traitance.show');

// Route::get('/frange-payement/{record}/download', [FrangePayementController::class, 'downloadFrangePayement'])->name('FrangePayement.download');
// Route::get('/bns-dechet/{record}/bon-sortie', [BnsDechetController::class, 'downloadBonSortie'])->name('dechet.bon_sortie');


// Route::get('/transactions/{transaction}/details', [TransactionController::class, 'details'])->name('transaction.details');

// Route::get('/admin/rh/paie/pointages/mark-attendance', [MarkAttendanceController::class, 'index'])->name('mark-attendance.index');
Route::post('/mark-attendance/store', [MarkAttendanceController::class, 'store'])->name('mark-attendance.store');

// Route::get('/packages/{package}/print', [PackageTicketController::class, 'print'])
//     ->name('package.print')
//     ->middleware(['auth']);

//     Route::get('/packages/{qr_code}', function ($qrCode) {
//         $package = Package::with('product')
//                     ->where('qr_code', $qrCode)
//                     ->firstOrFail();
                    
//         return response()->json([
//             'qr_code' => $package->qr_code,
//             'product' => [
//                 'code_article' => $package->product->code_article,
//                 'size' => $package->product->size,
//                 'color' => $package->product->color
//             ],
//             'quantity' => $package->quantity,
//             'status' => $package->status,
//             'created_at' => $package->created_at->format('Y-m-d H:i')
//         ]);
//     })->missing(function () {
//         return response()->json(['message' => 'Package not found'], 404);
//     });


Route::prefix('admin')->group(function () {
    // Route::post('/deliveries', [DeliveryController::class, 'store'])->name('deliveries.store');
    Route::get('/packages/{qrCode}', [DeliveryController::class, 'show'])->name('show');
});
// Route::post('/admin/deliveries', [DeliveryController::class, 'store']);
Route::get('/print-delivery/{delivery}', [DeliveryController::class, 'print'])
    ->name('delivery.print');

Route::post('/admin/deliveries', [DeliveryController::class, 'store'])->name('admin.deliveries.store');


Route::get('/packages/{package}/print-sticker', [PackageStickerController::class, 'print'])
    ->name('packages.print-sticker');


Route::put('/admin/deliveries/{delivery}', [DeliveryController::class, 'update'])
    ->name('admin.deliveries.update');
Route::get('/admin/packages/search', [PackageController::class, 'search']);


Route::get('/admin/packages-info/{qrCode}', action: [PackageInfoController::class, 'show']);