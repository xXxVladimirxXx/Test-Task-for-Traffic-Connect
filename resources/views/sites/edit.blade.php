@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($site) ? 'Edit' : 'Create' }} Site</h1>

    <form action="{{ isset($site) ? route('sites.update', $site) : route('sites.store') }}" method="POST">
        @csrf
        @if(isset($site)) @method('PUT') @endif

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $site->name ?? '') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Url</label>
            <input type="text" name="url" value="{{ old('url', $site->url ?? '') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Existing Server</label>
            <select name="server_id" class="form-control">
                <option value="">— none —</option>
                @foreach($servers as $s)
                    <option value="{{ $s->id }}" {{ (old('server_id', $site->server_id ?? '') == $s->id) ? 'selected' : '' }}>
                        {{ $s->name }} (ID: {{ $s->id }})
                    </option>
                @endforeach
            </select>
            <div class="form-check mt-2">
                <input type="checkbox" name="create_server" value="1" class="form-check-input" id="create_server">
                <label class="form-check-label" for="create_server">Create new server automatically</label>
            </div>
        </div>

        <div class="mb-3">
            <label>Existing CDN</label>
            <select name="cdn_id" class="form-control">
                <option value="">— none —</option>
                @foreach($cdns as $c)
                    <option value="{{ $c->id }}" {{ (old('cdn_id', $site->cdn_id ?? '') == $c->id) ? 'selected' : '' }}>
                        {{ $c->name }} (ID: {{ $c->id }})
                    </option>
                @endforeach
            </select>
            <div class="form-check mt-2">
                <input type="checkbox" name="create_cdn" value="1" class="form-check-input" id="create_cdn">
                <label class="form-check-label" for="create_cdn">Create new CDN automatically</label>
            </div>
        </div>

        <h5>Site credential (optional)</h5>
        <div class="mb-3">
            <label>Login</label>
            <input type="text" name="credential[login]" value="{{ old('credential.login', $site->credential->login ?? '') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="text" name="credential[password]" value="{{ old('credential.password', $site->credential->password ?? '') }}" class="form-control">
        </div>

        <button class="btn btn-primary">{{ isset($site) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection
