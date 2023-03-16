<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<header>
    <div class="left">
        <a href="index.php" class="btn highlight">Blind Test</a>
    </div>

    <div class="right">

        <?php if(isset($_SESSION['id'])): ?>
            <?php if($_SESSION['admin'] == 1): ?>
                <a href="admin.php" class="btn"><ion-icon name="settings-outline"></ion-icon></a>
            <?php endif; ?>
            <a href="profile.php" class="btn"><ion-icon name="person-outline"></ion-icon></a>
            <a href="logout.php" class="btn"><ion-icon name="log-out-outline"></ion-icon></a>
        <?php else : ?>
            <a href="login.php" class="btn"><ion-icon name="person-outline"></ion-icon></a>
        <?php endif; ?>

    </div>
</header>
