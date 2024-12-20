<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout - IKEH</title>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/checkout.css') ?>">
</head>

<body>
    <div class="checkout-container">
        <h1>Konfirmasi Belanja</h1>
        <?php if ($cart_items): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Harga Satuan</th>
                        <th>Kuantitas</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr class="cart-item" data-cart-id="<?= $item['cart_id'] ?>">
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>Rp. <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td class="total-price"><?= number_format($item['quantity'], 0, ',', '.') ?></td>
                            <td class="total-price">Rp. <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="total">Total: Rp.<?= number_format($total_amount, 2); ?></p>

            <form method="POST" action="<?= base_url('place-order') ?>">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <input type="hidden" name="total_amount" value="<?= $total_amount ?>">
            <label for="payment_method">Metode Pembayaran:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="Credit Card">Credit Card</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="PayPal">PayPal</option>
            </select>
            <button type="submit" class="btn">Pesan Sekarang</button>
            </form> 

        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
        <a href="<?= site_url('cart/' . $user_id); ?>" class="btn-kembali">Kembali ke Cart</a>
    </div>
</body>
</html>
