</div>
</div class="container">
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1) !important; margin-top:2em">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white">&copy;IT-Hub Kết nối - Chia sẻ - Học hỏi
                </p>
            </div>
            <div class="col-lg-6 text-center text-md-right">
                <ul class="nav d-inline-flex">
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Help</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $path;?>js/notification.js"></script>
    <script src="<?php echo $path;?>js/rightmenu.js"></script>
    <script> 
        // Bắt đầu tìm kiếm khi tài liệu đã sẵn sàng
    document.addEventListener("DOMContentLoaded", function() {
    // Lấy danh sách tất cả các .notification-item
    var notificationItems = document.querySelectorAll(".notification-item");

    // Duyệt qua từng .notification-item
    notificationItems.forEach(function(item) {
        // Bắt đầu xử lý khi hover vào .notification-item
        item.addEventListener("mouseenter", function() {
            // Tìm dropdown trong .notification-item và hiển thị nó
            var dropdown = item.querySelector(".dropdown");
            if (dropdown) {
                dropdown.style.display = "block";
            }
        });

        // Xử lý khi hover ra khỏi .notification-item
        item.addEventListener("mouseleave", function() {
            // Tìm dropdown trong .notification-item và ẩn nó
            var dropdown = item.querySelector(".dropdown");
            if (dropdown) {
                dropdown.style.display = "none";
            }
        });
    });
});

    </script>
</body>
</html>