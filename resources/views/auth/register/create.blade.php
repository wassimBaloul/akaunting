<x-layouts.auth>
    <x-slot name="title">
        {{ __('Register') }}
    </x-slot>

    <x-slot name="content">
        <h1>Register</h1>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Register</button>
        </form>
    </x-slot>
</x-layouts.auth>
