<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dynamic Dashboard</title>
  <!-- Font Awesome for icons -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4MNol7QzPxwOWa5t4lRDs9C4vGdAN3E6bOozcKW7v1z4+pbjMZtm2VWwg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      
    }

    body {
      background-color: #f0f0f0;
    }

    /* Header */
    .header {
      width: 100%;
      height: 60px;
      background: rgb(44, 45, 46);
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 0 20px;
      position: fixed;
      top: 0;
      z-index: 1000;
    }

    .header .title {
      font-size: 1.2rem;
      font-weight: bold;
    }

    .header .header-icons {
      display: flex;
      gap: 20px;
    }

    .header .header-icons i {
      cursor: pointer;
      font-size: 1.2rem;
      transition: color 0.3s;
    }

    .header .header-icons i:hover {
      color: #555;
    }

    /* Dashboard container */
    .dashboard-container {
      display: flex;
      margin-top: 60px; /* Offset for the header */
      height: calc(100vh - 60px);
      width: 100%;
    }

    /* Sidebar */
    .sidebar {
      background-color: rgb(35, 36, 37);
      color: #fff;
      height: 100%;
      width: 250px; /* Expanded width */
      transition: width 0.3s;
      position: relative;
    }

    .sidebar.collapsed {
      width: 70px; /* Collapsed width */
    }

    .sidebar-nav {
      display: flex;
      flex-direction: column;
      margin-top: 60px;
    }

    .toggle-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      font-size: 1.2rem;
      background: transparent;
      border: none;
      color: #fff;
    }

    .nav-item {
      display: flex;
      align-items: center;
      padding: 15px 20px;
      cursor: pointer;
      transition: background-color 0.3s;
      white-space: nowrap;
      overflow: hidden;
    }

    .sidebar.collapsed .nav-item {
      justify-content: center;
    }

    .nav-item:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .nav-item i {
      margin-right: 20px;
      font-size: 1.1rem;
      transition: margin 0.3s;
    }

    .sidebar.collapsed .nav-item span {
      display: none;
    }

    .nav-item.active {
      background-color: rgba(255, 255, 255, 0.2);
      padding: 15px 20px;
      border-radius: 25px 0px 0px 25px;
      margin-left: 25px;
      margin-top: 2px;
      margin-bottom: 2px;
    }

    /* Main Content */
    .main-content {
      flex: 1;
      padding: 20px;
      background-color: rgb(40, 43, 46);
      overflow-y: auto;
    }

    .loading-spinner {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }

    .loading-spinner span {
      font-size: 1.5rem;
      color: #555;
    }
  </style>
</head>
<body>

<!-- Header -->
<div class="header">
  <div class="title">My Dashboard</div>
  <div class="header-icons">
    <i class="fas fa-cog" title="Settings"></i>
    <i class="fas fa-user-circle" title="Profile"></i>
  </div>
</div>

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
  // Toggle sidebar (expand or collapse)
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
  }

  // Navigate to a specific route and load its content dynamically
  function navigateTo(route, event) {
    // Highlight the active button
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => item.classList.remove('active'));
    event.currentTarget.classList.add('active');

    // Show a loading spinner in the main content area
    const mainContent = document.getElementById('main-content');
    mainContent.innerHTML = `<div class="loading-spinner"><span>Loading...</span></div>`;

    // Fetch content from the route
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

</body>
</html>
