<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$pages = $pdo->query("
    SELECT *
    FROM pages
    ORDER BY id DESC
")->fetchAll();

?>

<style>
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
    .premium-pages-table {
        min-width: 850px !important;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 mb-md-5">
        <div>
            <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
                Pages
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Structure static site paths, edit structural metadata strings, and monitor page route allocations.
            </p>
        </div>

        <div>
            <a href="add_page.php" class="btn px-4 py-2" style="
                background: linear-gradient(135deg, #38bdf8, #0284c7);
                color: #ffffff;
                font-size: 14px;
                font-weight: 600;
                border-radius: 8px;
                border: none;
                box-shadow: 0 4px 12px rgba(56, 189, 248, 0.15);
                transition: all 0.2s ease-in-out;
            "
            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.3)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.15)';"
            >
                Add Page
            </a>
        </div>
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

                <table class="table premium-pages-table align-middle mb-0" style="color: #e2e8f0; border-color: rgba(255, 255, 255, 0.03);">
                    
                    <thead style="background: rgba(255, 255, 255, 0.02); border-bottom: 2px solid rgba(255, 255, 255, 0.05);">
                        <tr>
                            <th class="px-4 py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 90px;">ID</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Title</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 260px;">Slug</th>
                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 140px;">Status</th>
                            <th class="text-center py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 180px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($pages as $page): ?>
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03); background: transparent; transition: background 0.2s;" 
                                onmouseover="this.style.background='rgba(255,255,255,0.01)';" 
                                onmouseout="this.style.background='transparent';">
                                
                                <td class="px-4">
                                    <span style="font-size: 13px; font-family: monospace; color: #38bdf8; font-weight: 600;">
                                        #<?= $page['id'] ?>
                                    </span>
                                </td>

                                <td>
                                    <div style="font-weight: 600; font-size: 14px; color: #ffffff; padding-right: 20px;">
                                        <?= htmlspecialchars($page['title']) ?>
                                    </div>
                                </td>

                                <td>
                                    <span style="font-family: monospace; font-size: 13px; color: #94a3b8; background: rgba(255,255,255,0.02); padding: 4px 8px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.04);">
                                        /<?= htmlspecialchars($page['slug']) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge px-2.5 py-1.5" style="
                                        font-size: 11px;
                                        background: rgba(56, 189, 248, 0.08);
                                        color: #38bdf8;
                                        border: 1px solid rgba(56, 189, 248, 0.15);
                                        font-weight: 500;
                                        border-radius: 6px;
                                        text-transform: uppercase;
                                        letter-spacing: 0.03em;
                                    ">
                                        <?= ucfirst($page['status']) ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit_page.php?id=<?= $page['id'] ?>" class="btn btn-sm px-2.5 py-1.5" style="
                                            background: rgba(255, 255, 255, 0.03);
                                            color: #e2e8f0;
                                            border: 1px solid rgba(255, 255, 255, 0.08);
                                            font-weight: 500;
                                            font-size: 12.5px;
                                            border-radius: 6px;
                                            transition: all 0.2s;
                                        "
                                        onmouseover="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.color='#ffffff';"
                                        onmouseout="this.style.background='rgba(255, 255, 255, 0.03)'; this.style.color='#e2e8f0';">
                                            Edit
                                        </a>

                                        <a href="delete_page.php?id=<?= $page['id'] ?>" class="btn btn-sm px-2.5 py-1.5" onclick="return confirm('Delete page?')" style="
                                            background: rgba(239, 68, 68, 0.05);
                                            color: #f87171;
                                            border: 1px solid rgba(239, 68, 68, 0.15);
                                            font-weight: 500;
                                            font-size: 12.5px;
                                            border-radius: 6px;
                                            transition: all 0.2s;
                                        "
                                        onmouseover="this.style.background='rgba(239, 68, 68, 0.15)'; this.style.color='#ef4444';"
                                        onmouseout="this.style.background='rgba(239, 68, 68, 0.05)'; this.style.color='#f87171';">
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