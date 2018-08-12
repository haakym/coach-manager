<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ route('calendar.index') }}">
            {{ config('app.name', 'Coach Manager') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('calendar.index') }}">Calendar</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Courses
                    </a>
                    <div class="dropdown-menu" aria-labelledby="coursesDropDown">
                        <a class="dropdown-item" href="{{ route('datatables.courses.index') }}">All</a>
                        <a class="dropdown-item" href="{{ route('courses.create') }}">New</a>
                    </div>
                </li>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Instructors
                    </a>
                    <div class="dropdown-menu" aria-labelledby="instructorsDropDown">
                        <a class="dropdown-item" href="{{ route('datatables.instructors.index') }}">All</a>
                        <a class="dropdown-item" href="{{ route('instructors.create') }}">New</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>