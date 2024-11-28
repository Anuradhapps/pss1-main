<x-guest-layout>
@section('title', 'Login')
<x-auth-card>
    <div class="flex justify-between">
        <a href="{{ route('password.request') }}">Don't have an account?</a>
        @if (Route::has('register'))
            <a class="px-3 py-1 bg-green-600 rounded-lg hover:bg-green-700 hover:shadow-xl" href="{{ route('register') }}">Register</a>
        @endif
    </div>
	<x-form class="mt-3" action="{{ route('login') }}">
        <p class="mb-3">If you have an account, please login</p>
		@include('errors.messages')

		<x-form.input name="email" label="Email">{{ old('email') }}</x-form.input>
		<x-form.input name="password" label="Password" type="password" />

		<div class="flex justify-between">
			<a href="{{ route('password.request') }}"></a>
			@if (Route::has('register'))
                <a href="{{ route('register') }}"></a>
            @endif
		</div>

		<p><button type="submit" class="justify-center w-full px-4 py-2 text-sm text-white bg-blue-500 rounded shadow-md hover:bg-blue-700 hover:shadow-lg">Login</button></p>

	</x-form>

</x-auth-card>

</x-guest-layout>
