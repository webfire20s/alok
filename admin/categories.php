<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$stmt = $pdo->query("
    SELECT *
    FROM categories
    ORDER BY id DESC
");

$categories = $stmt->fetchAll();

?>

<style>
    /* Styling the container scrollbar for a sleek dark mode look */
    .custom-table-scroll::-webkit-scrollbar {
        height: 6px;
    }
    .custom-table-scroll::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 10px;
    }
    .custom-table-scroll::-webkit-scrollbar-thumb {
        background: rgba(56, 189, 248, 0.2);
        border-radius: 10px;
    }
    .custom-table-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(56, 189, 248, 0.4);
    }
    
    /* Hover Glow Effect for Action Buttons */
    .btn-glow-transition {
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }
    .btn-glow-transition:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(56, 189, 248, 0.4) !important;
    }

    /* Force the table to keep its complete structure without compressing columns */
    .premium-table {
        min-width: 750px !important;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 mb-md-5">
        <div>
            <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
                Categories
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Organize, class-assign, and manage production groups for glass designs.
            </p>
        </div>

        <a href="add_category.php" class="btn px-4 py-2 btn-glow-transition" style="
            background: linear-gradient(135deg, #38bdf8, #0284c7);
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(56, 189, 248, 0.25);
        ">
            Add Category
        </a>
    </div>

    <div class="card border-0" style="
        border-radius: 14px;
        background: rgba(21, 25, 34, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        overflow: hidden;
    ">
        <div class="card-body p-0">
            
            <div class="table-responsive custom-table-scroll" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">

                <table class="table premium-table align-middle mb-0" style="color: #e2e8f0; border-color: rgba(255, 255, 255, 0.03);">
                    
                    <thead style="background: rgba(255, 255, 255, 0.02); border-bottom: 2px solid rgba(255, 255, 255, 0.05);">
                        <tr>
                            <th class="px-4 py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">ID</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Image</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Name</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Slug</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Featured</th>
                            <th class="text-center py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($categories as $category): ?>
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03);">
                                
                                <td class="px-4">
                                    <span style="font-size: 13px; font-family: monospace; color: #475569; font-weight: 600;">
                                        #<?= $category['id'] ?>
                                    </span>
                                </td>

                                <td width="120">
                                    <?php if(!empty($category['image'])): ?>
                                        <div style="
                                            width: 80px;
                                            height: 80px;
                                            overflow: hidden;
                                            border-radius: 8px;
                                            border: 1px solid rgba(255, 255, 255, 0.05);
                                            background: rgba(15, 17, 21, 0.8);
                                        ">
                                            <img 
                                                src="../<?= htmlspecialchars($category['image']) ?>" 
                                                style="width: 100%; height: 100%; object-fit: cover;"
                                                alt="<?= htmlspecialchars($category['name']) ?>"
                                            >
                                        </div>
                                    <?php else: ?>
                                        <div style="
                                            width: 80px;
                                            height: 80px;
                                            border-radius: 8px;
                                            border: 1px dashed rgba(255, 255, 255, 0.1);
                                            background: rgba(255, 255, 255, 0.01);
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 10px;
                                            color: #475569;
                                        ">
                                            No Image
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div style="font-weight: 600; font-size: 15px; color: #ffffff; line-height: 1.4;">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </div>
                                </td>

                                <td>
                                    <span style="font-family: monospace; color: #94a3b8; font-size: 13px; background: rgba(255,255,255,0.02); padding: 2px 6px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.04);">
                                        <?= htmlspecialchars($category['slug']) ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if($category['featured']): ?>
                                        <span class="badge px-3 py-2" style="
                                            font-size: 12px;
                                            background: rgba(16, 185, 129, 0.1);
                                            color: #10b981;
                                            border: 1px solid rgba(16, 185, 129, 0.15);
                                            font-weight: 500;
                                            border-radius: 6px;
                                        ">
                                            Featured
                                        </span>
                                    <?php else: ?>
                                        <span class="badge px-3 py-2" style="
                                            font-size: 12px;
                                            background: rgba(255, 255, 255, 0.03);
                                            color: #64748b;
                                            border: 1px solid rgba(255, 255, 255, 0.05);
                                            font-weight: 500;
                                            border-radius: 6px;
                                        ">
                                            Standard
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="edit_category.php?id=<?= $category['id'] ?>" class="btn btn-sm px-3 py-1.5" style="
                                            background: rgba(255,255,255,0.03);
                                            color: #e2e8f0;
                                            border: 1px solid rgba(255,255,255,0.08);
                                            font-weight: 500;
                                            font-size: 13px;
                                            border-radius: 6px;
                                            transition: all 0.2s;
                                        "
                                        onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#ffffff';"
                                        onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.color='#e2e8f0';">
                                            Edit
                                        </a>

                                        <a href="delete_category.php?id=<?= $category['id'] ?>" class="btn btn-sm px-3 py-1.5" style="
                                            background: rgba(239, 68, 68, 0.05);
                                            color: #f87171;
                                            border: 1px solid rgba(239, 68, 68, 0.1);
                                            font-weight: 500;
                                            font-size: 13px;
                                            border-radius: 6px;
                                            transition: all 0.2s;
                                        "
                                        onmouseover="this.style.background='rgba(239, 68, 68, 0.15)'"
                                        onmouseout="this.style.background='rgba(239, 68, 68, 0.05)'"
                                        onclick="return confirm('Delete category?')">
                                            Delete
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    
                </table>

            </div>
        </div>
    </div>

</div>

</body>
</html>