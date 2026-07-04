<?php

require 'includes/auth.php';
require '../includes/db.php';


$stmt = $pdo->query("
SELECT *
FROM video_gallery
ORDER BY
featured DESC,
sort_order ASC,
id DESC
");

$videos = $stmt->fetchAll();
include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

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
    .premium-video-table {
        min-width: 950px !important;
    }
</style>

<div class="content-wrapper py-4">
    <div class="container-fluid">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 mb-md-5">
            <div>
                <h3 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
                    Video Gallery
                </h3>
                <p style="color: #64748b; font-size: 14px; margin: 0;">
                    Manage multimedia streaming indexes, coordinate external dynamic API resources, and configure asset sorting presets.
                </p>
            </div>

            <div>
                <a href="add_video.php" class="btn px-4 py-2" style="
                    background: linear-gradient(135deg, #38bdf8, #0284c7);
                    color: #ffffff;
                    font-size: 14px;
                    font-weight: 600;
                    border-radius: 8px;
                    border: none;
                    box-shadow: 0 4px 12px rgba(56, 189, 248, 0.15);
                    transition: all 0.2s ease-in-out;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                "
                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.3)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.15)';"
                >
                    <i class="fa fa-plus" style="font-size: 12px;"></i>
                    Add Video
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

                <?php if(empty($videos)): ?>
                    <div class="p-4">
                        <div class="alert mb-0" style="
                            background: rgba(234, 179, 8, 0.06) !important;
                            border: 1px solid rgba(234, 179, 8, 0.15) !important;
                            color: #fde047 !important;
                            font-size: 14px;
                            border-radius: 8px;
                        ">
                            No videos found.
                        </div>
                    </div>
                <?php else: ?>

                    <div class="table-responsive custom-table-scroll" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">

                        <table class="table premium-video-table align-middle mb-0" style="color: #e2e8f0; border-color: rgba(255, 255, 255, 0.03);">
                            
                            <thead style="background: rgba(255, 255, 255, 0.02); border-bottom: 2px solid rgba(255, 255, 255, 0.05);">
                                <tr>
                                    <th class="px-4 py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 160px;">Thumbnail</th>
                                    <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">Title</th>
                                    <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 150px;">Category</th>
                                    <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 120px;">Featured</th>
                                    <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 120px;">Status</th>
                                    <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 90px;">Sort</th>
                                    <th class="text-center py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; width: 180px;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php foreach($videos as $video): ?>
                                <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.03); background: transparent; transition: background 0.2s;" 
                                    onmouseover="this.style.background='rgba(255,255,255,0.01)';" 
                                    onmouseout="this.style.background='transparent';">
                                    
                                    <td class="px-4 py-3">
                                        <div style="position: relative; border-radius: 6px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); background: #0f1115;">
                                            <img
                                                src="https://img.youtube.com/vi/<?= htmlspecialchars($video['youtube_id']) ?>/mqdefault.jpg"
                                                class="img-fluid d-block"
                                                alt="Video frame"
                                                style="width: 100%; height: auto; transform: scale(1.01);"
                                            >
                                        </div>
                                    </td>

                                    <td>
                                        <div style="font-weight: 600; font-size: 14px; color: #ffffff; line-height: 1.4; margin-bottom: 4px; padding-right: 15px;">
                                            <?= htmlspecialchars($video['title']) ?>
                                        </div>
                                        <div style="font-family: monospace; font-size: 12px; color: #475569; word-break: break-all; padding-right: 15px;">
                                            <?= htmlspecialchars($video['youtube_url']) ?>
                                        </div>
                                    </td>

                                    <td>
                                        <span style="font-size: 13px; color: #94a3b8; font-weight: 500;">
                                            <?= htmlspecialchars($video['category']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php if($video['featured']): ?>
                                            <span class="badge px-2 py-1" style="font-size: 11px; background: rgba(34, 197, 94, 0.08); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.15); font-weight: 500; border-radius: 4px;">
                                                Featured
                                            </span>
                                        <?php else: ?>
                                            <span class="badge px-2 py-1" style="font-size: 11px; background: rgba(255, 255, 255, 0.04); color: #64748b; border: 1px solid rgba(255, 255, 255, 0.04); font-weight: 500; border-radius: 4px;">
                                                No
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if($video['status']=='active'): ?>
                                            <span class="badge px-2 py-1" style="font-size: 11px; background: rgba(56, 189, 248, 0.08); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.15); font-weight: 500; border-radius: 4px;">
                                                Active
                                            </span>
                                        <?php else: ?>
                                            <span class="badge px-2 py-1" style="font-size: 11px; background: rgba(239, 68, 68, 0.08); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.15); font-weight: 500; border-radius: 4px;">
                                                Inactive
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span style="font-family: monospace; font-size: 13px; color: #94a3b8; font-weight: 600;">
                                            <?= $video['sort_order'] ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="edit_video.php?id=<?= $video['id'] ?>" class="btn btn-sm px-2.5 py-1.5" style="
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

                                            <a href="delete_video.php?id=<?= $video['id'] ?>" class="btn btn-sm px-2.5 py-1.5" onclick="return confirm('Delete this video?');" style="
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
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>