<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<header>
    <div class="left">
        <a href="/blindtest" class="btn highlight">Blind Test</a>
    </div>

    <div class="right">

        <?php if(isset($_SESSION['id'])): ?>
            <?php if($_SESSION['admin'] == 1): ?>
                <a href="/blindtest/admin/admin.php" class="btn"><ion-icon name="settings-outline"></ion-icon></a>
            <?php endif; ?>
            <a href="/blindtest/profile.php" class="btn"><ion-icon name="person-outline"></ion-icon></a>
            <a href="/blindtest/logout.php" class="btn"><ion-icon name="log-out-outline"></ion-icon></a>
        <?php else : ?>
            <a href="/blindtest/login.php" class="btn"><ion-icon name="person-outline"></ion-icon></a>
        <?php endif; ?>

    </div>
</header>
