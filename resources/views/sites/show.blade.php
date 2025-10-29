@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Site</h1>

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $site->name ?? '') }}" class="form-control" disabled>
    </div>

    <div class="mb-3">
        <label>Url</label>
        <input type="text" name="url" value="{{ old('url', $site->url ?? '') }}" class="form-control" disabled>
    </div>

    <div class="mb-3">
        <label>Server</label>
        {{ $site->server->name }}
    </div>

    <div class="mb-3">
        <label>CDN</label>
        {{ $site->cdn->name }}
    </div>

    <h5>Site credential</h5>
    <div class="mb-3">
        <label>Login</label>
        <input type="text" name="credential[login]" value="{{ old('credential.login', $site->credential->login ?? '') }}" class="form-control" disabled>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="text" name="credential[password]" value="{{ old('credential.password', $site->credential->password ?? '') }}" class="form-control" disabled>
    </div>
</div>
@endsection
