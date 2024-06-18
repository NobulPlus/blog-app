<x-slot name="header">
    <header class=""header>
        <nav class="nav-style">
            <div class="logo">
                <img src="https://www.cdnlogo.com/logos/t/30/teamgrid.svg" alt="">
            </div>
            <div class="list">
                <li><a href="">Home</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Contact Us</a></li>
            </div>
            <div>
                <a href="{{ route('create.post') }}" class="btn btn-primary">Create Post</a>
            </div>
        </nav>
    </header>
</x-slot>