<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM bulk_inquiries
    WHERE id = ?
");

$stmt->execute([$id]);

$inquiry = $stmt->fetch();

if(!$inquiry){

    die('Inquiry not found');

}

/*
|--------------------------------------------------------------------------
| UPDATE STATUS
|--------------------------------------------------------------------------
*/

if(
    $_SERVER['REQUEST_METHOD'] === 'POST'
){
    $status =
        trim($_POST['status']);

    $allowed = [

        'new',
        'contacted',
        'quotation_sent',
        'converted',
        'closed'

    ];

    if(in_array($status, $allowed)){

        $update = $pdo->prepare("
            UPDATE bulk_inquiries
            SET status = ?
            WHERE id = ?
        ");

        $update->execute([
            $status,
            $id
        ]);

        header(
            "Location:view_bulk_inquiry.php?id=".$id
        );

        exit;
    }
}

?>

<h2 class="mb-4">

    Bulk Inquiry Details

</h2>

<div class="card-box p-4">

    <div class="row">

        <div class="col-md-8">

            <p>

                <strong>Customer:</strong>

                <?= htmlspecialchars(
                    $inquiry['customer_name']
                ) ?>

            </p>

            <p>

                <strong>Company:</strong>

                <?= htmlspecialchars(
                    $inquiry['company_name']
                ) ?>

            </p>

            <p>

                <strong>Email:</strong>

                <?= htmlspecialchars(
                    $inquiry['email']
                ) ?>

            </p>

            <p>

                <strong>Phone:</strong>

                <?= htmlspecialchars(
                    $inquiry['phone']
                ) ?>

            </p>

            <p>

                <strong>Product:</strong>

                <?= htmlspecialchars(
                    $inquiry['product_name']
                ) ?>

            </p>

            <p>

                <strong>Quantity:</strong>

                <?= htmlspecialchars(
                    $inquiry['quantity']
                ) ?>

            </p>

            <hr>

            <h5>

                Requirements

            </h5>

            <div
                class="border p-3 bg-light"
                style="min-height:120px;"
            >

                <?= nl2br(
                    htmlspecialchars(
                        $inquiry['message']
                    )
                ) ?>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border">

                <div class="card-body">

                    <form method="POST">

                        <div class="form-group">

                            <label>

                                Inquiry Status

                            </label>

                            <select
                                name="status"
                                class="form-control"
                            >

                                <?php

                                $statuses = [

                                    'new',
                                    'contacted',
                                    'quotation_sent',
                                    'converted',
                                    'closed'

                                ];

                                foreach($statuses as $status):

                                ?>

                                    <option
                                        value="<?= $status ?>"
                                        <?= $inquiry['status']==$status ? 'selected' : '' ?>
                                    >

                                        <?= ucfirst(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $status
                                            )
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <button
                            class="btn btn-dark btn-block"
                        >

                            Update Status

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</div>
</body>
</html>