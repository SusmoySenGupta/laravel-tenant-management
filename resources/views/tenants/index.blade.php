@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tenants') }}</div>

                <div class="card-body">
                    <a href="{{ route('tenants.create') }}" class="btn btn-primary">{{ __('Add New Tenant') }}</a>
                    <br><br>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <table class="table text-center">
                                <thead class="">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Domain</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tenants as $tenant)
                                        <tr>
                                            <td>{{ $tenant->name }}</td>
                                            <td>{{ $tenant->email }}</td>
                                            <td>{{ $tenant->domain }}</td>
                                            <td>
                                                <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-info">
                                                    {{ __('Edit') }}
                                                </a>
                                                <form action="{{ route('tenants.destroy', $tenant) }}" method="POST"  style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No tenants found...</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
