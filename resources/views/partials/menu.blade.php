<ul class="site-menu" data-plugin="menu">
    <li class="site-menu-category">General</li>
    <li class="site-menu-item{{$active==1?' active':''}}">
        <a href="{{route('admin-home')}}">
            <i class="site-menu-icon fas fa-home wb-dashboard"></i>
            <span class="site-menu-title">Home</span>
        </a>
    </li>
    <li class="site-menu-item{{$active==2?' active':''}}">
        <a href="{{route('users.index')}}">
            <i class="site-menu-icon fas fa-users wb-dashboard"></i>
            <span class="site-menu-title">Users</span>
        </a>
    </li>
    <li class="site-menu-item{{$active==3?' active':''}}">
        <a href="{{route('event-types.index')}}">
            <i class="site-menu-icon fas fa-calendar-week wb-dashboard"></i>
            <span class="site-menu-title">Event Types</span>
        </a>
    </li>
    <li class="site-menu-item{{$active==4?' active':''}}">
        <a href="{{route('foods.index')}}">
            <i class="site-menu-icon fas fa-utensils wb-dashboard"></i>
            <span class="site-menu-title">Food types</span>
        </a>
    </li>
    <li class="site-menu-item{{$active==5?' active':''}}">
        <a href="{{route('drinks.index')}}">
            <i class="site-menu-icon fas fa-cocktail wb-dashboard"></i>
            <span class="site-menu-title">Drink types</span>
        </a>
    </li>
    <li class="site-menu-item{{$active==6?' active':''}}">
        <a href="{{route('questions.index')}}">
            <i class="site-menu-icon fas fa-question-circle wb-dashboard"></i>
            <span class="site-menu-title">Quiz questions</span>
        </a>
    </li>
    <li class="site-menu-item{{$active==7?' active':''}}">
        <a href="#">
            <i class="site-menu-icon fas fa-gifts wb-dashboard"></i>
            <span class="site-menu-title">QR Gift Codes</span>
        </a>
    </li>
</ul>
