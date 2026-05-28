<?php

session_start();

require 'includes/db.php';

include 'includes/header.php';

$sessionId = session_id();

/*
|--------------------------------------------------------------------------
| GET CART ITEMS
|--------------------------------------------------------------------------
*/

$userId = $_SESSION['user_id'] ?? null;

$sessionId = session_id();

if($userId){

    $stmt = $pdo->prepare("
        SELECT
            cart.*,
            products.name,
            products.image,
            products.slug,
            products.price
        FROM cart
        JOIN products
        ON cart.product_id = products.id
        WHERE cart.user_id = ?
        ORDER BY cart.id DESC
    ");

    $stmt->execute([$userId]);

}else{

    $stmt = $pdo->prepare("
        SELECT
            cart.*,
            products.name,
            products.image,
            products.slug,
            products.price
        FROM cart
        JOIN products
        ON cart.product_id = products.id
        WHERE cart.session_id = ?
        ORDER BY cart.id DESC
    ");

    $stmt->execute([$sessionId]);

}

$cartItems = $stmt->fetchAll();
$subtotal = 0;

$totalGST = 0;

?>

<div class="container pt-5 pb-5">

    <h2 class="mb-4">
        Shopping Cart
    </h2>

    <?php if(empty($cartItems)): ?>

        <div class="alert alert-warning">
            Your cart is empty.
        </div>

    <?php else: ?>

        <div class="table-responsive">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>Product</th>

                        <th>Image</th>

                        <th>Type</th>

                        <th>Qty</th>

                        <th>Pieces</th>

                        <th>Price</th>

                        <th>GST</th>

                        <th>Total</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($cartItems as $item): ?>

                        <?php

                        $qty = (int)$item['quantity'];

                        $price = (float)$item['price'];

                        $gstPercent = (float)$item['gst_percent'];

                        $piecesPerBox = (int)$item['pieces_per_box'];

                        $orderUnit = $item['order_unit'];

                        if($orderUnit == 'box'){

                            $pieces =
                            $qty * $piecesPerBox;

                        }else{

                            $pieces = $qty;

                        }

                        $lineSubtotal =
                        $price * $qty;

                        $gstAmount =
                        ($lineSubtotal * $gstPercent) / 100;

                        $lineTotal =
                        $lineSubtotal + $gstAmount;

                        $subtotal += $lineSubtotal;

                        $totalGST += $gstAmount;

                        ?>

                        <tr>

                            <td>

                                <a href="product/<?= $item['slug'] ?>">

                                    <?= htmlspecialchars($item['name']) ?>

                                </a>

                            </td>

                            <td width="120">

                                <img
                                    src="<?= trim(htmlspecialchars($item['image'])) ?>"
                                    class="img-fluid"
                                    style="
                                        width: 90px;
                                        height: 90px;
                                        object-fit: contain;
                                    "
                                >

                            </td>

                            <td>

                                <?= ucfirst($orderUnit) ?>

                            </td>

                            <td width="150">

                                <form
                                    action="update_cart.php"
                                    method="POST"
                                    class="text-center"
                                >

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= $item['id'] ?>"
                                    >

                                    <input
                                        type="number"
                                        name="quantity"
                                        value="<?= $qty ?>"
                                        min="1"
                                        class="form-control text-center mb-2"
                                        style="
                                            width: 80px;
                                            margin: auto;
                                        "
                                    >

                                    <button
                                        class="btn btn-dark btn-sm"
                                        type="submit"
                                    >
                                        Update
                                    </button>

                                </form>

                            </td>

                            <td>

                                <?= $pieces ?>

                            </td>

                            <td>

                                ₹<?= number_format($price, 2) ?>

                            </td>

                            <td>

                                <?= $gstPercent ?>%

                            </td>

                            <td>

                                ₹<?= number_format($lineTotal, 2) ?>

                            </td>

                            <td>

                                <a
                                    href="remove_cart.php?id=<?= $item['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                >
                                    Remove
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <?php

        $grandTotal =
        $subtotal + $totalGST;

        ?>

        <div class="row justify-content-end">

            <div class="col-md-4">

                <table class="table table-bordered">

                    <tr>

                        <th>
                            Subtotal
                        </th>

                        <td>
                            ₹<?= number_format($subtotal, 2) ?>
                        </td>

                    </tr>

                    <tr>

                        <th>
                            GST
                        </th>

                        <td>
                            ₹<?= number_format($totalGST, 2) ?>
                        </td>

                    </tr>

                    <tr>

                        <th>
                            Grand Total
                        </th>

                        <td class="font-weight-bold">
                            ₹<?= number_format($grandTotal, 2) ?>
                        </td>

                    </tr>

                </table>

                <a
                    href="checkout.php"
                    class="btn btn-org btn-block"
                >
                    Proceed to Checkout
                </a>

            </div>

        </div>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>