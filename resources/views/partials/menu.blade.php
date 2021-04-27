<ul class="site-menu" data-plugin="menu">
    <li class="site-menu-category">General</li>
    <li class="site-menu-item{{ active($active == 1) }}">
        <a href="{{ route('admin-home') }}">
            <i class="site-menu-icon fas fa-home wb-dashboard"></i>
            <span class="site-menu-title">Home</span>
        </a>
    </li>
    <li class="site-menu-item{{ active($active == 2) }}">
        <a href="{{ route('users.index') }}">
            <i class="site-menu-icon fas fa-users wb-dashboard"></i>
            <span class="site-menu-title">Users</span>
        </a>
    </li>
    <li class="site-menu-item{{ active($active == 3) }}">
        <a href="{{ route('event-types.index') }}">
            <i class="site-menu-icon fas fa-calendar-week wb-dashboard"></i>
            <span class="site-menu-title">Event Types</span>
        </a>
    </li>
    <li class="site-menu-item{{ active($active == 4) }}">
        <a href="{{ route('foods.index') }}">
            <i class="site-menu-icon fas fa-utensils wb-dashboard"></i>
            <span class="site-menu-title">Food Types</span>
        </a>
    </li>
    <li class="site-menu-item{{ active($active == 5) }}">
        <a href="{{ route('drinks.index') }}">
            <i class="site-menu-icon fas fa-cocktail wb-dashboard"></i>
            <span class="site-menu-title">Drink Types</span>
        </a>
    </li>
    <li class="site-menu-item{{ active($active == 6) }}">
        <a href="{{ route('questions.index') }}">
            <i class="site-menu-icon fas fa-question-circle wb-dashboard"></i>
            <span class="site-menu-title">Quiz Questions</span>
        </a>
    </li>
    <li class="site-menu-item{{ active($active == 7) }}">
        <a href="#">
            <i class="site-menu-icon fas fa-gifts wb-dashboard"></i>
            <span class="site-menu-title">QR Gift Codes</span>
        </a>
    </li>
    <li class="site-menu-category">External</li>
    <li class="site-menu-item">
        <a href="{{ env('GAME_URL') }}" target="_blank">
            <i class="site-menu-icon fas fa-gamepad wb-dashboard"></i>
            <span class="site-menu-title">Game</span>
        </a>
    </li>
</ul>
