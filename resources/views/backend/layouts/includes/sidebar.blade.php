<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        {{-- dashboard --}}
        @can('dashboard')
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? '' : 'collapsed' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @endcan

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'website' ? '' : 'collapsed' }}"
                href="{{ route('website') }}" target="_blank">
                <i class="bi bi-globe"></i>
                <span>Website</span>
            </a>
        </li><!-- End Website Nav -->

        @can('update-setting')
        <li class="nav-heading text-info">User Management ----------------------------------</li>
        @endcan

        {{-- designations --}}
        @can('list-designation')
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'designatios.index' ? '' : 'collapsed' }}"
                href="{{ route('designations.index') }}">
                <i class="bi bi-person-badge-fill"></i>
                <span>Designations</span>
            </a>
        </li>
        @endcan

        {{-- departments --}}
        @can('list-department')
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'departments.index' ? '' : 'collapsed' }}"
                href="{{ route('departments.index') }}">
                <i class="bi bi-building"></i>
                <span>Departments</span>
            </a>
        </li>
        @endcan

        {{-- Patients --}}
        @canany(['list-patient', 'create-patient'])
        <li class="nav-item">
            <a class="nav-link {{ Route::is('patients.*') ? '' : 'collapsed' }}" data-bs-target="#patients-nav"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-fill"></i><span>Patients</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="patients-nav" class="nav-content collapse {{ Route::is('patients.*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                @can('create-patient')
                <li>
                    <a href="{{ route('patients.create') }}"
                        class="{{ Route::currentRouteName() == 'patients.create' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Patient</span>
                    </a>
                </li>
                @endcan
                @can('list-patient')
                <li>
                    <a href="{{ route('patients.index') }}"
                        class="{{ Route::currentRouteName() == 'patients.index' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Patients List</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        <!-- Doctors Nav -->
        @canany(['list-doctor', 'create-doctor'])
        <li class="nav-item">
            <a class="nav-link {{ Route::is('doctors.*') ? '' : 'collapsed' }}" data-bs-target="#doctor-nav"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-people-fill"></i><span>Doctor</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="doctor-nav" class="nav-content collapse {{ Route::is('doctors.*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                @can('create-user')
                <li>
                    <a href="{{ route('doctors.create') }}"
                        class="{{ Route::currentRouteName() == 'doctors.create' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Doctor</span>
                    </a>
                </li>
                @endcan
                @can('list-user')
                <li>
                    <a href="{{ route('doctors.index') }}"
                        class="{{ Route::currentRouteName() == 'doctors.index' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Doctor List</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['list-appointment', 'create-appointment'])
        <li class="nav-item">
            <a class="nav-link {{ Route::is('appointments.*') ? '' : 'collapsed' }}" data-bs-target="#appointment-nav"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-people-fill"></i><span>Appointment</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="appointment-nav" class="nav-content collapse {{ Route::is('appointments.*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                @can('create-user')
                <li>
                    <a href="{{ route('appointments.create') }}"
                        class="{{ Route::currentRouteName() == 'appointments.create' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Appointment</span>
                    </a>
                </li>
                @endcan
                @can('list-user')
                <li>
                    <a href="{{ route('appointments.index') }}"
                        class="{{ Route::currentRouteName() == 'appointments.index' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Appointment List</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        <!-- End Users Nav -->


        @can('update-setting')
        <li class="nav-heading text-info">Role and Permission Management -------</li>
        @endcan

        {{-- permissions --}}
        @can('list-permission')
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'permissions.index' ? '' : 'collapsed' }}"
                href="{{ route('permissions.index') }}">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Permissions</span>
            </a>
        </li>
        @endcan

        @can('list-role')
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'roles.index' || Route::currentRouteName() == 'role.permissions' ? '' : 'collapsed' }}"
                href="{{ route('roles.index') }}">
                <i class="bi bi-person-lines-fill"></i>
                <span>Roles</span>
            </a>
        </li>
        @endcan

        <!-- Users Nav -->
        @canany(['list-user', 'create-user'])
        <li class="nav-item">
            <a class="nav-link {{ Route::is('users.*') ? '' : 'collapsed' }}" data-bs-target="#users-nav"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-people-fill"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users-nav" class="nav-content collapse {{ Route::is('users.*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                @can('create-user')
                <li>
                    <a href="{{ route('users.create') }}"
                        class="{{ Route::currentRouteName() == 'users.create' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Add User</span>
                    </a>
                </li>
                @endcan
                @can('list-user')
                <li>
                    <a href="{{ route('users.index') }}"
                        class="{{ Route::currentRouteName() == 'users.index' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Users List</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany
        <!-- End Users Nav -->


        {{-- website settings --}}
        @can('update-setting')
        <li class="nav-heading text-info">Website Management ---------------------------</li>
        @endcan
        {{-- about us --}}
        @canany(['list-about-us', 'create-about-us'])
        <li class="nav-item">
            <a class="nav-link {{ Route::is('about-us.*') ? '' : 'collapsed' }}" data-bs-target="#about-nav"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-info-circle-fill"></i>
                </i><span>About Us</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="about-nav" class="nav-content collapse {{ Route::is('about-us.*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                @can('create-about-us')
                <li>
                    <a href="{{ route('about-us.create') }}"
                        class="{{ Route::currentRouteName() == 'about-us.create' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Add About</span>
                    </a>
                </li>
                @endcan
                @can('list-about-us')
                <li>
                    <a href="{{ route('about-us.index') }}"
                        class="{{ Route::currentRouteName() == 'about-us.index' ? 'active nav-link' : '' }}">
                        <i class="bi bi-circle"></i><span>About Us List</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        @can('update-setting')
        <li class="nav-heading text-info">Settings -------------------------------------------------</li>
        @endcan

        {{-- settings --}}
        @can('update-setting')
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'settings.index' ? '' : 'collapsed' }}"
                href="{{ route('settings.index') }}">
                <i class="bi bi-gear-fill"></i>
                <span>Setting</span>
            </a>
        </li>
        @endcan

    </ul>

</aside><!-- End Sidebar-->