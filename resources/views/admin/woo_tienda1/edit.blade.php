@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.store.actions.edit', ['name' => $store->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <store-form
                :action="'{{ $store->resource_url }}'"
                :data="{{ $store->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.woo_tiendas.actions.edit', ['name' => $store->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.woo_tiendas.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </store-form>

        </div>
    
</div>

@endsection