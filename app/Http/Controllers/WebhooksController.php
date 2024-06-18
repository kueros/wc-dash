<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Webhook\BulkDestroyWebhook;
use App\Http\Requests\Admin\Webhook\DestroyWebhook;
use App\Http\Requests\Admin\Webhook\IndexWebhook;
use App\Http\Requests\Admin\Webhook\StoreWebhook;
use App\Http\Requests\Admin\Webhook\UpdateWebhook;
use App\Models\Webhook;
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

class WebhooksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexWebhook $request
     * @return array|Factory|View
     */
    public function index($request)
    {

		$data = DB::table('webhooks')
			->leftJoin('woo_tiendas', 'webhooks.shopId', '=', 'woo_tiendas.id')
			->where('webhooks.shopId', $request)
			->get();

        return view('admin.webhook.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.webhook.create');

        return view('admin.webhook.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWebhook $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreWebhook $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Webhook
        $webhook = Webhook::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/webhooks'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/webhooks');
    }

    /**
     * Display the specified resource.
     *
     * @param Webhook $webhook
     * @throws AuthorizationException
     * @return void
     */
    public function show(Webhook $webhook)
    {
        $this->authorize('admin.webhook.show', $webhook);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Webhook $webhook
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Webhook $webhook)
    {
        $this->authorize('admin.webhook.edit', $webhook);


        return view('admin.webhook.edit', [
            'webhook' => $webhook,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWebhook $request
     * @param Webhook $webhook
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateWebhook $request, Webhook $webhook)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Webhook
        $webhook->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/webhooks'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/webhooks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyWebhook $request
     * @param Webhook $webhook
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyWebhook $request, Webhook $webhook)
    {
        $webhook->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyWebhook $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyWebhook $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Webhook::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
