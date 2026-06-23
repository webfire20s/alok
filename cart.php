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

<div class="container pt-5 pb-5" style="font-family: 'Montserrat', sans-serif;">

    <h2 class="text-uppercase mb-4" style="font-size: 24px; font-weight: 700; color: #111111; letter-spacing: 0.05em; position: relative; padding-bottom: 12px;">
        Shopping Cart
        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background-color: #c8232c;"></span>
    </h2>

    <?php if(empty($cartItems)): ?>
        
        <div class="alert py-3 px-4" style="background-color: #fffdf0; border-left: 4px solid #f0ad4e; border-top: 1px solid #faebcc; border-right: 1px solid #faebcc; border-bottom: 1px solid #faebcc; color: #8a6d3b; font-size: 14px; font-weight: 500; border-radius: 4px;">
            Your cart is empty.
        </div>

    <?php else: ?>

        <div class="table-responsive mb-5" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff;">
            <table class="table align-middle mb-0" style="font-size: 13px; color: #333333;">
                
                <thead>
                    <tr style="background-color: #111111; color: #ffffff;">
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Product</th>
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Image</th>
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Type</th>
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px; text-align: center;">Qty</th>
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Pieces</th>
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Price</th>
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">GST</th>
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px;">Total</th>
                        <th style="padding: 14px 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 0; font-size: 11px; text-align: right;">Action</th>
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
                            $pieces = $qty * $piecesPerBox;
                        }else{
                            $pieces = $qty;
                        }

                        $lineSubtotal = $price * $qty;
                        $gstAmount = ($lineSubtotal * $gstPercent) / 100;
                        $lineTotal = $lineSubtotal + $gstAmount;

                        $subtotal += $lineSubtotal;
                        $totalGST += $gstAmount;
                        ?>
                        
                        <tr style="border-bottom: 1px solid #eeeeee;">
                            
                            <td style="padding: 16px; font-weight: 600;">
                                <a href="product/<?= $item['slug'] ?>" style="color: #111111; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#c8232c'" onmouseout="this.style.color='#111111'">
                                    <?= htmlspecialchars($item['name']) ?>
                                </a>
                            </td>
                            
                            <td style="padding: 16px;" width="120">
                                <div style="border: 1px solid #eeeeee; border-radius: 4px; padding: 4px; background-color: #ffffff; display: inline-block;">
                                    <img
                                        src="<?= trim(htmlspecialchars($item['image'])) ?>"
                                        class="img-fluid"
                                        style="width: 80px; height: 80px; object-fit: contain; display: block;"
                                    >
                                </div>
                            </td>
                            
                            <td style="padding: 16px; text-transform: uppercase; font-size: 11px; font-weight: 700; color: #666666; letter-spacing: 0.02em;">
                                <?= ucfirst($orderUnit) ?>
                            </td>
                            
                            <td style="padding: 16px;" width="150">
                                <form action="update_cart.php" method="POST" class="text-center d-flex flex-column align-items-center">
                                    
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    
                                    <input
                                        type="number"
                                        name="quantity"
                                        value="<?= $qty ?>"
                                        min="1"
                                        class="form-control text-center mb-2"
                                        style="width: 70px; height: 34px; border-radius: 4px; border: 1px solid #cccccc; font-size: 13px; font-weight: 600; box-shadow: none; padding: 4px;"
                                    >
                                    
                                    <button class="btn text-uppercase" type="submit" style="background-color: #111111; color: #ffffff; font-size: 10px; font-weight: 700; padding: 4px 12px; border-radius: 4px; letter-spacing: 0.05em; transition: all 0.2s ease-in-out;" onmouseover="this.style.backgroundColor='#c8232c'" onmouseout="this.style.backgroundColor='#111111'">
                                        Update
                                    </button>

                                </form>
                            </td>
                            
                            <td style="padding: 16px; font-weight: 500; color: #555555;">
                                <?= $pieces ?> pcs
                            </td>
                            
                            <td style="padding: 16px; font-weight: 500; color: #555555;">
                                ₹<?= number_format($price, 2) ?>
                            </td>
                            
                            <td style="padding: 16px; font-weight: 500; color: #777777;">
                                <?= $gstPercent ?>%
                            </td>
                            
                            <td style="padding: 16px; font-weight: 700; color: #111111;">
                                ₹<?= number_format($lineTotal, 2) ?>
                            </td>
                            
                            <td style="padding: 16px; text-align: right;">
                                <a href="remove_cart.php?id=<?= $item['id'] ?>" class="btn text-uppercase" style="background-color: transparent; border: 1px solid #e0e0e0; color: #888888; font-size: 11px; font-weight: 600; padding: 6px 14px; border-radius: 4px; transition: all 0.2s ease-in-out;" onmouseover="this.style.backgroundColor='#fff5f5'; this.style.borderColor='#c8232c'; this.style.color='#c8232c';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#e0e0e0'; this.style.color='#888888';">
                                    Remove
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <?php
        $grandTotal = $subtotal + $totalGST;
        ?>

        <div class="row justify-content-end">
            <div class="col-md-4">
                
                <div style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; padding: 24px; margin-bottom: 20px;">
                    
                    <h4 class="text-uppercase mb-4" style="font-size: 14px; font-weight: 700; color: #111111; letter-spacing: 0.05em; border-bottom: 1px solid #eeeeee; padding-bottom: 12px; margin-top: 0;">
                        Order Summary
                    </h4>

                    <div class="d-flex justify-content-between mb-3" style="font-size: 14px; color: #555555;">
                        <span style="font-weight: 500;">Subtotal</span>
                        <span style="font-weight: 600; color: #111111;">₹<?= number_format($subtotal, 2) ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-4" style="font-size: 14px; color: #555555; border-bottom: 1px dashed #eeeeee; padding-bottom: 14px;">
                        <span style="font-weight: 500;">Estimated GST</span>
                        <span style="font-weight: 600; color: #111111;">₹<?= number_format($totalGST, 2) ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center" style="font-size: 16px; color: #111111;">
                        <span style="font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 0.02em;">Grand Total</span>
                        <span style="font-weight: 700; font-size: 18px; color: #c8232c;">₹<?= number_format($grandTotal, 2) ?></span>
                    </div>

                </div>

                <a
                    href="checkout.php"
                    class="btn text-uppercase w-100"
                    style="background-color: #111111; color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 0.05em; padding: 14px 24px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out;"
                    onmouseover="this.style.backgroundColor='#c8232c'; this.style.borderColor='#c8232c';"
                    onmouseout="this.style.backgroundColor='#111111'; this.style.borderColor='#111111';"
                >
                    Proceed to Checkout
                </a>

            </div>
        </div>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>