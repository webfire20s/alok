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
    SELECT *
    FROM order_items
    WHERE order_id = ?
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
'assets/themes/storefront/public/images/logoe8da.png';

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

$pdf->Cell(100, 6, 'Ajanta Packaging', 0, 0);

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
    6,
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

    $pdf->Cell(
        60,
        10,
        substr($item['product_name'], 0, 30),
        1
    );

    $pdf->Cell(
        18,
        10,
        $item['quantity'],
        1,
        0,
        'C'
    );

    $pdf->Cell(
        25,
        10,
        ucfirst($item['order_unit']),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        25,
        10,
        'Rs. ' .
        number_format($item['price'], 2),
        1,
        0,
        'R'
    );

    $pdf->Cell(
        20,
        10,
        $item['gst_percent'] . '%',
        1,
        0,
        'C'
    );

    $pdf->Cell(
        42,
        10,
        'Rs. ' .
        number_format($item['line_total'], 2),
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