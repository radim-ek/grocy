@extends('layout.default')

@section('title', $__t('Permissions for user %s', GetUserDisplayName($user)))
@section('activeNav', '')
@section('viewJsName', 'userpermissions')

@push('pageScripts')
<script>
	Grocy.EditObjectId = {{ $user->id }};
</script>
@endpush

@section('content')
<div class="row">
	<div class="col">
		<h2 class="title">@yield('title')</h2>
	</div>
</div>
<hr>
<div class="row mt-3">
	<div class="col">
		<ul>
			@foreach($permissions as $perm)
			<li>
				@include('components.userpermission_select', array(
				'permission' => $perm
				))
			</li>
			@endforeach
		</ul>
		<button id="permission-save"
			class="btn btn-success"
			type="submit">{{ $__t('Save') }}</button>
	</div>
</div>
@endsection
