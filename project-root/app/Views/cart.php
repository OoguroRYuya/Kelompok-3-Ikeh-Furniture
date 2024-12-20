<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - IKEH</title>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cart.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/footer.css') ?>">

</head>
<body class="home-page">
<header>
        <div class="logo">
            <h1>IKEH</h1>
        </div>
        <div class="toggle-btn" id="menuToggle">
            <i class="fa-solid fa-bars"></i>
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

    <main>
        <div class="cart-container">
            <h1>Pesanan Belanja</h1>
        
            <?php if ($cart_items): ?>
                <div class="cart-table-container">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th></th>
                                <th>Harga Satuan</th>
                                <th>Kuantitas</th>
                                <th>Total Harga</th>
                                <th>Batal</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php 
                            $total_price_all_items = 0; 
                            foreach ($cart_items as $item): 
                                $item_total_price = $item['price'] * $item['quantity'];
                                $total_price_all_items += $item_total_price; 
                            ?>
                                <tr class="cart-item" data-stock="<?= $item['stock'] ?>">
                                    <td>
                                        <img src="<?= base_url('images/' . htmlspecialchars($item['image'])) ?>" 
                                            alt="<?= htmlspecialchars($item['name']) ?>" >
                                    </td>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td>Rp. <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    <td>
                                        <form method="POST" action="<?= site_url('cart/updateQuantity/' . htmlspecialchars($item['cart_id'])) ?>">
                                            <button type="submit" name="action" value="decrease" class="quantity-btn decrease">-</button>
                                            <input type="text" class="quantity-input" value="<?= htmlspecialchars($item['quantity']) ?>" readonly>
                                            <button type="submit" name="action" value="increase" class="quantity-btn increase">+</button>
                                        </form>
                                    </td>
                                    <td class="total-price">Rp. <?= number_format($item_total_price, 0, ',', '.') ?></td>
                                    <td>
                                        <a href="<?= site_url('cart/remove/' . htmlspecialchars($item['cart_id'])) ?>" 
                                        class="remove-btn">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h2 class="total">Total: Rp. <?= number_format($total_price_all_items, 0, ',', '.') ?></h2>
                </div>
                <div class="cart-actions">
                    <a href="<?= site_url('furniture/'. $user_id) ?>" class="btn">Tambah Barang</a>
                    <a href="<?= site_url('checkout/' . $user_id) ?>" class="btn">Checkout Pesanan</a>
                </div>
            <?php else: ?>
                <p class="kosong">Keranjang kosong.</p>
                <a href="<?= site_url('furniture/'. $user_id) ?>" class="btn">Tambah Barang</a>
            <?php endif; ?>
        </div>
    </main>
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
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartItems = document.querySelectorAll('.cart-item');

        cartItems.forEach(item => {
            const decreaseBtn = item.querySelector('.decrease');
            const increaseBtn = item.querySelector('.increase');
            const quantityInput = item.querySelector('.quantity-input');
            const totalPriceCell = item.querySelector('.total-price');
            const pricePerItem = parseInt(item.querySelector('td:nth-child(3)').textContent.replace(/[^0-9]/g, ''), 10);
            const maxStock = parseInt(item.dataset.stock, 10); // Ambil stok dari atribut data

            function updateTotalPrice() {
                const quantity = parseInt(quantityInput.value, 10);
                const totalPrice = pricePerItem * quantity;
                totalPriceCell.textContent = 'Rp. ' + totalPrice.toLocaleString('id-ID');
            }

            decreaseBtn.addEventListener('click', () => {
                let quantity = parseInt(quantityInput.value, 10);
                if (quantity > 1) {
                    quantity--;
                    quantityInput.value = quantity;
                    updateTotalPrice();
                }
            });

            increaseBtn.addEventListener('click', () => {
                let quantity = parseInt(quantityInput.value, 10);
                if (quantity < maxStock) { 
                    quantity++;
                    quantityInput.value = quantity;
                    updateTotalPrice();
                } else {
                    alert('Jumlah tidak dapat melebihi stok tersedia!');
                }
            });
        });
    });
</script>

</html>
