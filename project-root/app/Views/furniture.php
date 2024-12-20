<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Furniture - IKEH Store</title>
    <link rel="stylesheet" href="<?= base_url('css/hero.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/modal.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/furniture.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/footer.css') ?>">
    <!-- <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/furniture.css"> -->
</head>

<body>
<header>
        <div class="logo">
            <h1>IKEH</h1>
        </div>
        <div class="toggle-btn" id="menuToggle">
            <span class="menu-icon">|||</span>
        </div>
        <nav class="navbar" id="navbarMenu">
            <ul>
                <li><a href="<?= site_url('hero/'. $user_id) ?>">Beranda</a></li>
                <li><a href="<?= site_url('furniture/'. $user_id) ?>">Produk</a></li>
                <li><a href="<?= site_url('cart/'. $user_id) ?>">Keranjang</a></li>
                <li><a href="<?= site_url('orders/'. $user_id) ?>">Pesanan</a></li>
                <li>
                    <div class="user-menu">
                        <span id="username"><?php echo $username; ?></span>
                        <div class="dropdown-content">
                            <a href="<?php echo site_url('logout'); ?>" id="logout">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>        
    </header>

    <section class="furniture">
            <h2>Temukan Furniture Terbaik Kami</h2>
            <div class="grid-container">
                <?php foreach ($furniture_list as $item): ?>
                    <div class="furniture-item">
                        <div class="furniture-head">
                            <div class="furniture-image" style="background-image: url('<?= base_url('images/' . $item['image']) ?>');"></div>
                            <div class="furniture-name">
                                <h4><?= htmlspecialchars($item['name']) ?></h4>
                                <p class="text-muted">Rp.<?= number_format($item['price'], 2) ?></p>
                            </div>
                        </div>
                        <div class="furniture-desc">
                            <p class="text-muted"><?= htmlspecialchars($item['description']) ?></p>
                            <button class="btn" onclick="openModal(<?= $item['furniture_id'] ?>)">Buy Now</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>        
        </section>
    </main>

    <div id="buyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            
            <div class="furniture-image" id="furniture-image" style="background-size:cover; border-radius: 8px;"></div>
            <div class="furniture-desc">
                <h2 id="furniture-name"></h2>
                <div class="furniture-data">
                    <p class="text-muted">Rp.<span id="furniture-price"></span></p>
                    <p class="text-muted"><span id="furniture-stock"></span> Stok</p>                
                </div>
            </div>
            <form method="POST" action="<?= site_url('cart/add') ?>">
                <div class="furniture-input">
                    <input type="hidden" name="furniture_id" id="furniture-id">
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <div class="quantity-container">
                        <button type="button" class="btn quantity-btn" onclick="decreaseQuantity()">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1">
                        <button type="button" class="btn quantity-btn" onclick="increaseQuantity()">+</button>
                    </div>
                    <button type="submit" class="btn">Tambah ke Keranjang</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section about">
                <h2>Tentang IKEH</h2>
                <p>IKEH menghadirkan furniture berkualitas tinggi untuk memenuhi kebutuhan rumah Anda. Gaya modern, nyaman, dan tahan lama.</p>
            </div>
            <div class="footer-section contact">
                <h2>Kontak Kami</h2>
                <ul>
                    <li>Email: <a href="mailto:support@ikeh.com">ikehfurniture@gmail.com</a></li>
                    <li>Telepon: +62 813-8385-1226</li>
                    <li>Alamat: Bandung, Jawa Barat</li>
                </ul>
            </div>
            <div class="footer-section links">
                <h2>Tautan Cepat</h2>
                <ul>
                    <li><a href="<?= site_url('hero/'. $user_id) ?>">Beranda</a></li>
                    <li><a href="<?= site_url('furniture/'. $user_id) ?>">Produk</a></li>
                    <li><a href="<?= site_url('cart/'. $user_id) ?>">Keranjang</a></li>
                    <li><a href="<?= site_url('orders/'. $user_id) ?>">Pesanan</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> IKEH Furniture Store. All rights reserved.</p>
        </div>
    </footer>
    <script>
        const furnitureData = <?= json_encode($furniture_list) ?>;
        const modal = document.getElementById("buyModal");
        const furnitureName = document.getElementById("furniture-name");
        const furniturePrice = document.getElementById("furniture-price");
        const furnitureStock = document.getElementById("furniture-stock");
        const furnitureIdInput = document.getElementById("furniture-id");
        const base_url = '<?= base_url() ?>';

        function openModal(furnitureId) {
            const selectedFurniture = furnitureData.find(item => item.furniture_id == furnitureId);

            if (!selectedFurniture) {
            console.error("Furniture tidak ditemukan:", furnitureId);
            return;
            }

            furnitureName.innerText = selectedFurniture.name;
            furniturePrice.innerText = parseFloat(selectedFurniture.price).toFixed(2);
            furnitureStock.innerText = selectedFurniture.stock;
            furnitureIdInput.value = selectedFurniture.furniture_id;

            const furnitureImage = document.getElementById("furniture-image");
            furnitureImage.style.backgroundImage = `url('${base_url}/images/${selectedFurniture.image}')`;

            document.getElementById("quantity").setAttribute("max", selectedFurniture.stock);

            modal.style.display = "flex";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        function increaseQuantity() {
            const quantityInput = document.getElementById("quantity");
            const maxQuantity = parseInt(quantityInput.getAttribute("max")) || Infinity;
            let currentValue = parseInt(quantityInput.value) || 1;

            if (currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById("quantity");
            let currentValue = parseInt(quantityInput.value) || 1;

            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        document.getElementById("logout").addEventListener("click", function(e) {
            e.preventDefault();
            window.location.href = "/logout";
        });

        const menuToggle = document.getElementById("menuToggle");
        const navbarMenu = document.getElementById("navbarMenu");
        const menuIcon = document.querySelector(".menu-icon");

        menuToggle.addEventListener("click", function () {
            navbarMenu.classList.toggle("active");
            if (navbarMenu.classList.contains("active")) {
                menuIcon.textContent = "X";
            } else {
                menuIcon.textContent = "|||";
            }
        });
        
    </script>

</body>
</html>
