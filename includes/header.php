<style>
    body {
        display: flex;
        margin: 0;
        padding: 0;
    }

    #sidebar {
        width: 250px;
        /* Adjust based on your sidebar width */
        position: fixed;
        height: 100vh;
    }

    #main-content {
        flex: 1;
    }

    nav {
        background: #1c2531;
        width: 100%;
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 20px 20px;
        box-shadow: 0px 6px 3px -2px rgba(81, 81, 81, 0.61);
        -webkit-box-shadow: 0px 6px 3px -2px rgba(81, 81, 81, 0.61);
        -moz-box-shadow: 0px 6px 3px -2px rgba(81, 81, 81, 0.61);
    }

    nav,
    .menu-btn {
        display: flex;
        justify-content: start;
        align-items: center;
        margin: 0 20px 0 0;
    }

    .menu-btn {
        right: 9px;
        top: 2.5%;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: start;
        cursor: pointer;
        color: #ffffff;
    }

    .menu-btn:hover i {
        color: #ffd000;
    }

    .menu-btn i {
        transition: all 0.3s;
    }

    .nav-title h1 {
        float: left;
        color: white;
    }

    /* Ensure search-btn and user-icon are pushed to the end */
    nav .search-btn {
        margin-left: auto;
    }

    nav .user-icon {
        margin: 0 120px 0 120px;
        /* Adjust spacing as needed */
    }
</style>
<nav>
    <div class="menu-btn">
        <i class="fa-solid fa-bars"></i>
    </div>
    <div class="nav-title">
        <h1>Dashboard</h1>
    </div>
    <div class="search-btn">
        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
    </div>
    <div class="user-icon">
        <a href="#" class="profile">
            <img src="assets/img/people.png">
        </a>
    </div>
</nav>