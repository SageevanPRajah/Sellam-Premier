<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
              <link
                  rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
                  integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4MNol7QzPxwOWa5t4lRDs9C4vGdAN3E6bOozcKW7v1z4+pbjMZtm2VWwg=="
                  crossorigin="anonymous"
                  referrerpolicy="no-referrer"
              />
              <style>
                  /* Your CSS here */
                  body {
                      background-color: #f0f0f0;
                  }

                  .header {
                      width: 100%;
                      height: 60px;
                      background: rgb(44, 45, 46);
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                      padding: 0 20px;
                      position: fixed;
                      top: 0;
                      z-index: 1000;
                  }

                  .dashboard-container {
                      display: flex;
                      margin-top: 60px;
                      height: calc(100vh - 60px);
                  }

                  .sidebar {
                      background-color: rgb(35, 36, 37);
                      color: #fff;
                      height: 100%;
                      width: 250px;
                      transition: width 0.3s;
                  }

                  .main-content {
                      flex: 1;
                      padding: 20px;
                      background-color: rgb(40, 43, 46);
                      overflow-y: auto;
                  }

                  .toggle-btn {
                      position: absolute;
                      top: 10px;
                      right: 10px;
                      cursor: pointer;
                  }
              </style>

              <!-- Success Message -->
              @if(session()->has('success'))
                  <div class="bg-green-500 text-white p-4 rounded mb-4">
                      {{ session('success') }}
                  </div>
              @endif

              <!-- Error Messages -->
              @if($errors->any())
                  <div class="bg-red-500 text-white p-4 rounded mb-4">
                      <ul>
                          @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

              <!-- Dashboard Container -->
              <div class="dashboard-container">
                  <!-- Sidebar -->
                  <div class="sidebar" id="sidebar">
                      <button class="toggle-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
                          <i class="fas fa-bars"></i>
                      </button>
                      <div class="sidebar-nav">
                          <div class="nav-item active" onclick="navigateTo('/movie', event)">
                              <i class="fas fa-film"></i>
                              <span>Movies</span>
                          </div>
                          <div class="nav-item" onclick="navigateTo('/show', event)">
                              <i class="fas fa-tv"></i>
                              <span>Shows</span>
                          </div>
                          <div class="nav-item" onclick="navigateTo('/booking', event)">
                              <i class="fas fa-ticket-alt"></i>
                              <span>Booking</span>
                          </div>
                          <div class="nav-item" onclick="navigateTo('/seats', event)">
                              <i class="fas fa-chair"></i>
                              <span>Seats</span>
                          </div>
                          <div class="nav-item" onclick="navigateTo('/summary', event)">
                              <i class="fas fa-chart-bar"></i>
                              <span>Summary</span>
                          </div>
                      </div>
                  </div>

                  <!-- Main Content -->
                  <div class="main-content" id="main-content">
                      <div class="loading-spinner">
                          <span>Select a section to view content</span>
                      </div>
                  </div>
              </div>

              <script>
                  function toggleSidebar() {
                      const sidebar = document.getElementById('sidebar');
                      sidebar.classList.toggle('collapsed');
                  }

                  function navigateTo(route, event) {
                      const navItems = document.querySelectorAll('.nav-item');
                      navItems.forEach(item => item.classList.remove('active'));
                      event.currentTarget.classList.add('active');

                      const mainContent = document.getElementById('main-content');
                      mainContent.innerHTML = `<div class="loading-spinner"><span>Loading...</span></div>`;

                      fetch(route)
                          .then(response => {
                              if (!response.ok) {
                                  throw new Error(`Error fetching ${route}: ${response.statusText}`);
                              }
                              return response.text();
                          })
                          .then(html => {
                              mainContent.innerHTML = html;
                          })
                          .catch(error => {
                              mainContent.innerHTML = `<div class="loading-spinner"><span>Error: ${error.message}</span></div>`;
                          });
                  }
              </script>
          </div>
      </div>
  </div>
</x-app-layout>
