<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\BulkDestroyStore;
use App\Http\Requests\Admin\Store\DestroyStore;
use App\Http\Requests\Admin\Store\IndexStore;
use App\Http\Requests\Admin\Store\StoreStore;
use App\Http\Requests\Admin\Store\UpdateStore;
use App\Models\Store;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StoresController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @param IndexStore $request
	 * @return array|Factory|View
	 */

	public function index()
	{

		$data =
			Store::select(
				'stores.id',
				'stores.token',
				'stores.code',
				'stores.cuit',
				'stores.shop',
				'stores.fapiusr',
				'stores.fapiclave',
				'stores.hmac',
				'stores.host',
				'stores.state'
			)
			->leftJoin(
				DB::raw(
					'(SELECT shopId, 
                                MAX(webhookId) AS webhookId, 
                                MAX(url) AS url, 
                                MAX(tipo) AS tipo, 
                                MAX(state) AS state 
                                FROM webhooks 
                                GROUP BY shopId) AS grouped_webhooks'
				),
				function ($join) {
					$join->on(
						'stores.id',
						'=',
						'grouped_webhooks.shopId'
					);
				}
			)
			->groupBy('stores.id') // Agrupa por el campo stores.id
			->get();

		#dd($data);
		return view('admin.store.index', ['data' => $data]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @throws AuthorizationException
	 * @return Factory|View
	 */
	public function create()
	{
		$this->authorize('admin.store.create');

		return view('admin.store.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StoreStore $request
	 * @return array|RedirectResponse|Redirector
	 */
	public function store(Store $request)
	{
		// Sanitize input
		$sanitized = $request->getSanitized();

		// Store the Store
		$store = Store::create($sanitized);

		if ($request->ajax()) {
			return ['redirect' => url('admin/stores'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
		}

		return redirect('admin/stores');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Store $store
	 * @throws AuthorizationException
	 * @return void
	 */
	public function show($store)
	{
		#$this->authorize('admin.store.show', $store);
		#dd($store);
		$stores = Store::find($store);
		return view('admin.store.show', [
			'store' => $stores,
		]);

		// TODO your code goes here
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Store $store
	 * @throws AuthorizationException
	 * @return Factory|View
	 */
	public function edit(Store $store)
	{

		$this->authorize('admin.store.edit', $store);


		return view('admin.store.edit', [
			'store' => $store,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateStore $request
	 * @param Store $store
	 * @return array|RedirectResponse|Redirector
	 */
	public function update(Store $request, Store $store)
	{
		// Sanitize input
		$sanitized = $request->getSanitized();

		// Update changed values Store
		$store->update($sanitized);

		if ($request->ajax()) {
			return [
				'redirect' => url('admin/stores'),
				'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
			];
		}

		return redirect('admin/stores');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroyStore $request
	 * @param Store $store
	 * @throws Exception
	 * @return ResponseFactory|RedirectResponse|Response
	 */
	public function destroy(Store $request, Store $store)
	{
		$store->delete();

		if ($request->ajax()) {
			return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
		}

		return redirect()->back();
	}

	/**
	 * Remove the specified resources from storage.
	 *
	 * @param BulkDestroyStore $request
	 * @throws Exception
	 * @return Response|bool
	 */
	public function bulkDestroy(Store $request): Response
	{
		DB::transaction(static function () use ($request) {
			collect($request->data['ids'])
				->chunk(1000)
				->each(static function ($bulkChunk) {
					Store::whereIn('id', $bulkChunk)->delete();

					// TODO your code goes here
				});
		});

		return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
	}
}
