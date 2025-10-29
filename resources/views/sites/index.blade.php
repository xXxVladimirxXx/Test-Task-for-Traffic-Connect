@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sites</h1>
    <a href="{{ route('sites.create') }}" class="btn btn-primary">Create site</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Domain</th>
                <th>Server</th>
                <th>CDN</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sites as $site)
                <tr>
                    <td>{{ $site->id }}</td>
                    <td>{{ $site->name }}</td>
                    <td>{{ $site->domain }}</td>
                    <td>@if ($site->server) {{ $site->server?->name }} (ID: {{ $site->server_id }}) @else - @endif</td>
                    <td>@if ($site->cdn) {{ $site->cdn?->name }} (ID: {{ $site->cdn_id }}) @else - @endif</td>
                    <td>
                        <a href="{{ route('sites.check', $site) }}" class="btn btn-sm btn-outline-primary me-3">
                            <i class="bi bi-wifi"></i> Check auth
                        </a>

                        <a href="{{ route('sites.show', $site) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('sites.edit', $site) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('sites.destroy', $site) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sites->links() }}
</div>
@endsection
