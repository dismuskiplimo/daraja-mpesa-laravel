@if(Session::has('success'))
	<div class="w-full bg-green-600 text-green-900">
		<div class="container mx-auto">
			<p><strong>Success!</strong>  {{ Session::get('success') }}.</p>
		</div>
	</div>
@endif

@if(Session::has('success'))
	<div class="w-full bg-red-600 text-red-900">
		<div class="container mx-auto">
			<p><strong>Error!</strong> {{ Session::get('error') }}.</p>
		</div>
	</div>
@endif

@if(count($errors))
	<div class="w-full bg-red-600 text-red-900">
		<div class="container mx-auto">
			<ul>
				<p><strong>Error!</strong></p>
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</ul>
		</div>
	</div>
@endif