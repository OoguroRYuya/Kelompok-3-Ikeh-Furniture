<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders - IKEH</title>
    <link rel="stylesheet" href="<?= base_url('css/common.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/orders.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/detail_order.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/footer.css'); ?>">
</head>
<body class="home-page">
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

<main>
    <div class="order-container">
        <h1>Pesanan Anda</h1>

        <?php if ($orders): ?>
            <table class="order-table">
            <thead>
                <tr>
                    <th>Nomor Pesanan</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>Pesanan - <?= htmlspecialchars($order['order_id']) ?></td>
                        <td>Rp. <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($order['delivery_status'] ?? 'Pending') ?></td>
                        <td>
                            <a 
                                href="#" 
                                class="info-btn" 
                                onclick="showOrderDetails(<?= htmlspecialchars($order['order_id']) ?>); return false;" 
                                title="Lihat info pesanan">
                                <span>i</span>
                            </a>
                        </td>

                        <td>
                            <?php if ($order['delivery_status'] == 'Pending'): ?>
                                <a href="<?= site_url('orders/cancel/' . htmlspecialchars($order['order_id'])) ?>" class="remove-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">Hapus</a>
                            <?php elseif ($order['delivery_status'] == 'Confirmed'): ?>
                                <span class="remove-btn" style="color: red;">Untuk membatalkan pesanan, hubungi admin.</span>
                            <?php elseif ($order['delivery_status'] == 'Delivered'): ?>
                                <span class="remove-btn" style="color: grey;">Tidak Bisa Dibatalkan</span>
                            <?php elseif ($order['delivery_status'] == 'Shipped'): ?>
                                <a href="<?= site_url('orders/removeOrderHistory/' . htmlspecialchars($order['order_id'])) ?>" class="remove-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat pesanan ini?');">Hapus Riwayat</a>      
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p style="margin-bottom: 20px;">Anda belum memiliki pesanan.</p>
            <a href="<?= site_url('furniture/'. $user_id) ?>" class="btn">Belanja Sekarang</a>
        <?php endif; ?>

        <a href="<?= site_url('hero/' . $user_id); ?>" class="btn">Kembali ke Beranda</a>
    </div>

    
</main>
    <div id="orderDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Detail Pesanan</h2>
            <div id="modal-body">
            </div>
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
        function showOrderDetails(orderId) {
        const modal = document.getElementById('orderDetailsModal');
        const modalBody = document.getElementById('modal-body');

        modalBody.innerHTML = 'Loading...';

        fetch(`<?= site_url('orders/details/') ?>${orderId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const orderDetails = data.data.orderDetails;
                    const shipment = data.data.shipment;

                    let content = '<ul>';
                    orderDetails.forEach(item => {
                        const furnitureImage = `<?= base_url('images/') ?>${item.furniture_image}`;
                        content += `
                            <li style="margin-bottom: 15px;">
                                <div style="display: flex; align-items: center;">
                                    <img src="${furnitureImage}" alt="${item.furniture_name}" style="width: 80px; height: 80px; object-fit: cover; margin-right: 15px; border-radius: 5px;">
                                    <div>
                                        <p><strong>${item.furniture_name}</strong></p>
                                        <p>${item.quantity} x Rp. ${item.price.toLocaleString()}</p>
                                    </div>
                                </div>
                            </li>`;
                    });
                    content += '</ul>';

                    content += `
                        <hr>
                        <p><strong>Status Pengiriman:</strong> ${shipment.delivery_status}</p>
                        <p><strong>Total Harga:</strong> Rp. ${orderDetails.reduce((total, item) => total + (item.price * item.quantity), 0).toLocaleString()}</p>
                    `;

                    modalBody.innerHTML = content;
                } else {
                    modalBody.innerHTML = `<p>${data.message}</p>`;
                }
            })
            .catch(err => {
                modalBody.innerHTML = '<p>Gagal memuat detail pesanan.</p>';
            });

        modal.style.display = 'block';
    }

    function closeModal() {
        const modal = document.getElementById('orderDetailsModal');
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('orderDetailsModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

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