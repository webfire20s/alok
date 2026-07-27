<?php

require 'includes/db.php';
require 'includes/fpdf/fpdf.php';

/*
|--------------------------------------------------------------------------
| GET ORDER
|--------------------------------------------------------------------------
*/

$orderId = (int)($_GET['order'] ?? 0);

$orderStmt = $pdo->prepare("
    SELECT *
    FROM orders
    WHERE id = ?
");

$orderStmt->execute([$orderId]);

$order = $orderStmt->fetch();

if(!$order){

    die("Order not found");

}

/*
|--------------------------------------------------------------------------
| GET ORDER ITEMS
|--------------------------------------------------------------------------
*/

$itemStmt = $pdo->prepare("
    SELECT
        order_items.*,
        closure_options.name AS closure_option_name
    FROM order_items
    LEFT JOIN closure_options
        ON order_items.closure_option_id = closure_options.id
    WHERE order_items.order_id = ?
");

$itemStmt->execute([$orderId]);

$items = $itemStmt->fetchAll();

/*
|--------------------------------------------------------------------------
| PDF
|--------------------------------------------------------------------------
*/

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetAutoPageBreak(true, 20);

/*
|--------------------------------------------------------------------------
| LOGO
|--------------------------------------------------------------------------
*/

$logoPath =
'assets/themes/storefront/public/images/logo.jpeg';

if(file_exists($logoPath)){

    $pdf->Image($logoPath, 10, 10, 40);

}

/*
|--------------------------------------------------------------------------
| COMPANY INFO
|--------------------------------------------------------------------------
*/

$pdf->SetFont('Arial', 'B', 18);

$pdf->Cell(0, 10, 'TAX INVOICE', 0, 1, 'R');

$pdf->Ln(10);

$pdf->SetFont('Arial', '', 11);

$pdf->Cell(100, 24, 'Alok Glass Works', 0, 0);

$pdf->Cell(
    90,
    6,
    'Invoice #: ' . $order['order_number'],
    0,
    1,
    'R'
);

$pdf->Cell(
    100,
    25,
    'India',
    0,
    0
);

$pdf->Cell(
    90,
    6,
    'Date: ' .
    date(
        'd M Y',
        strtotime($order['created_at'])
    ),
    0,
    1,
    'R'
);

$pdf->Ln(10);

/*
|--------------------------------------------------------------------------
| BILLING DETAILS
|--------------------------------------------------------------------------
*/

$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(0, 8, 'Billing Details', 0, 1);

$pdf->SetFont('Arial', '', 11);

$pdf->Cell(
    0,
    6,
    $order['customer_name'],
    0,
    1
);

$pdf->Cell(
    0,
    6,
    $order['customer_email'],
    0,
    1
);

$pdf->Cell(
    0,
    6,
    $order['customer_phone'],
    0,
    1
);

if(!empty($order['customer_company'])){

    $pdf->Cell(
        0,
        6,
        $order['customer_company'],
        0,
        1
    );

}

$pdf->MultiCell(
    0,
    6,
    $order['customer_address']
);

$pdf->Cell(
    0,
    6,
    $order['customer_city'] .
    ', ' .
    $order['customer_state'] .
    ' - ' .
    $order['customer_pincode'],
    0,
    1
);

$pdf->Ln(10);

/*
|--------------------------------------------------------------------------
| TABLE HEADER
|--------------------------------------------------------------------------
*/

$pdf->SetFont('Arial', 'B', 10);

$pdf->SetFillColor(230,230,230);

$pdf->Cell(60, 10, 'Product', 1, 0, 'C', true);

$pdf->Cell(18, 10, 'Qty', 1, 0, 'C', true);

$pdf->Cell(25, 10, 'Type', 1, 0, 'C', true);

$pdf->Cell(25, 10, 'Price', 1, 0, 'C', true);

$pdf->Cell(20, 10, 'GST', 1, 0, 'C', true);

$pdf->Cell(42, 10, 'Total', 1, 1, 'C', true);

/*
|--------------------------------------------------------------------------
| TABLE ITEMS
|--------------------------------------------------------------------------
*/

$pdf->SetFont('Arial', '', 10);

foreach($items as $item){

    $productPrice = (float)$item['price'];

    $closurePrice = (float)($item['closure_option_price'] ?? 0);

    // Price already includes closure price
    $effectivePrice = $productPrice;

    $productOnlyPrice = $effectivePrice - $closurePrice;

    $startX = $pdf->GetX();
    $startY = $pdf->GetY();

    $productText = $item['product_name'];

    if($closurePrice > 0){

        $productText .= "\nClosure : " . $item['closure_option_name'];

        // $productText .= "\nProduct : Rs. " . number_format($productOnlyPrice,2);

        $productText .= "\nClosure : Rs. " . number_format($closurePrice,2);

        $productText .= "\nUnit : Rs. " . number_format($effectivePrice,2);

    }

    $rowHeight = ($closurePrice > 0) ? 24 : 10;

    $pdf->MultiCell(
        60,
        6,
        $productText,
        1
    );

    $pdf->SetXY($startX + 60, $startY);

    $pdf->Cell(18,$rowHeight,$item['quantity'],1,0,'C');

    $pdf->Cell(
        25,
        $rowHeight,
        ucfirst($item['order_unit']),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        25,
        $rowHeight,
        'Rs. '.number_format($effectivePrice,2),
        1,
        0,
        'R'
    );

    $pdf->Cell(
        20,
        $rowHeight,
        $item['gst_percent'].'%',
        1,
        0,
        'C'
    );

    $pdf->Cell(
        42,
        $rowHeight,
        'Rs. '.number_format($item['line_total'],2),
        1,
        1,
        'R'
    );

}
/*
|--------------------------------------------------------------------------
| TOTALS
|--------------------------------------------------------------------------
*/

$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 11);

$pdf->Cell(148, 8, 'Subtotal', 1);

$pdf->Cell(
    42,
    8,
    'Rs. ' .
    number_format($order['subtotal'], 2),
    1,
    1,
    'R'
);

$pdf->Cell(148, 8, 'GST Total', 1);

$pdf->Cell(
    42,
    8,
    'Rs. ' .
    number_format($order['gst_total'], 2),
    1,
    1,
    'R'
);

/*
|--------------------------------------------------------------------------
| SHIPPING
|--------------------------------------------------------------------------
*/

$pdf->Cell(148, 8, 'Shipping', 1);

$pdf->Cell(
    42,
    8,
    'Rs. ' .
    number_format($order['shipping_charge'], 2),
    1,
    1,
    'R'
);

/*
|--------------------------------------------------------------------------
| GRAND TOTAL
|--------------------------------------------------------------------------
*/

$pdf->Cell(148, 10, 'Grand Total', 1);

$pdf->Cell(
    42,
    10,
    'Rs. ' .
    number_format($order['grand_total'], 2),
    1,
    1,
    'R'
);
/*
|--------------------------------------------------------------------------
| PAYMENT INFO
|--------------------------------------------------------------------------
*/

$pdf->Ln(10);

$pdf->SetFont('Arial', '', 10);

$pdf->Cell(
    0,
    6,
    'Payment Method: ' .
    ucfirst($order['payment_method']),
    0,
    1
);

$pdf->Cell(
    0,
    6,
    'Order Status: ' .
    ucfirst($order['order_status']),
    0,
    1
);

/*
|--------------------------------------------------------------------------
| FOOTER
|--------------------------------------------------------------------------
*/

$pdf->Ln(15);

$pdf->SetFont('Arial', 'I', 9);

$pdf->MultiCell(
    0,
    5,
    'This is a computer-generated invoice and does not require a physical signature.'
);

/*
|--------------------------------------------------------------------------
| OUTPUT
|--------------------------------------------------------------------------
*/

$pdf->Output(
    'I',
    'Invoice-' .
    $order['order_number'] .
    '.pdf'
);