-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th5 28, 2024 lúc 04:16 PM
-- Phiên bản máy phục vụ: 8.0.31
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_elegant_watch`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `brand_id` int NOT NULL,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brand_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brand_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `brand_desc`, `brand_image`) VALUES
(1, 'Rolex', 'Thương hiệu Rolex là một trong những thương hiệu đồng hồ xa xỉ và sang trọng nhất trên thế giới. Được thành lập vào năm 1905 bởi Hans Wilsdorf và Alfred Davis tại London, Anh Quốc, Rolex đã trở thành biểu tượng của sự thượng lưu và đẳng cấp.', 'logo.png'),
(2, 'Longines', 'Longines là một trong những thương hiệu đồng hồ xa xỉ hàng đầu thế giới, có trụ sở tại Saint-Imier, Thụy Sĩ. Thương hiệu này được thành lập vào năm 1832 bởi Auguste Agassiz. Longines nổi tiếng với sự kết hợp hoàn hảo giữa truyền thống và hiện đại.', 'logo-1.png'),
(3, 'Casio', 'Casio là một trong những thương hiệu đồng hồ nổi tiếng và có uy tín từ Nhật Bản, được biết đến với sự đa dạng và tính đơn giản trong thiết kế. Casio không chỉ là một thương hiệu đồng hồ mà còn là biểu tượng của sự đa dạng, đổi mới và tính tiện ích', 'logo-2.png'),
(4, 'Hublot', 'Hublot là một trong những thương hiệu đồng hồ cao cấp hàng đầu thế giới. Được thành lập vào năm 1980 bởi Carlo Crocco, Hublot đã nhanh chóng gây ấn tượng và tạo ra những bước đột phá trong ngành công nghiệp đồng hồ thụy Sỹ.', 'logo-3.png'),
(5, 'Citizen', 'Thương hiệu Citizen là một trong những thương hiệu đồng hồ nổi tiếng trên toàn thế giới. Với hơn 100 năm kinh nghiệm trong ngành công nghiệp đồng hồ, Citizen đã xây dựng một danh tiếng vững chắc trong việc sản xuất các sản phẩm chất lượng và độc đáo.', 'logo-4.png'),
(16, 'Bulova', 'Đồng hồ Bulova được biết đến với chất lượng cao, thiết kế tinh tế và giá cả hợp lý. Bulova cung cấp một loạt các mẫu đồng hồ, bao gồm đồng hồ cơ, đồng hồ quartz, đồng hồ thể thao và đồng hồ thời trang.', 'logo.jpg'),
(24, 'Calvin Klein', 'Calvin Klein là một trong những thương hiệu thời trang hàng đầu thế giới, nổi tiếng với sự độc đáo và tinh tế trong thiết kế. Sự kết hợp giữa phong cách hiện đại và sự tinh tế, độc đáo, mang đến sự sang trọng và phong cách cho người sở hữu.', 'logo-5.png'),
(26, 'Movado', 'Thương hiệu Movado đã lập nên một dấu ấn trong thế giới đồng hồ bằng sự kết hợp giữa thiết kế tối giản và chất lượng tinh tế. Movado, từ tiếng Esperanto có nghĩa là \"chuyển động\", là biểu tượng của sự đổi mới và sự thanh lịch', 'logo-7.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`customer_id`, `product_id`, `quantity`, `price`) VALUES
(24, 2, 2, 6085000),
(31, 34, 4, 1107798000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(3, 'Đồng hồ cặp đôi'),
(4, 'Đồng hồ Unisex'),
(5, 'Đồng hồ đính kim cương'),
(6, 'Đồng hồ bản giới hạn'),
(10, 'Đồng hồ quân đội'),
(12, 'Đồng hồ tự động'),
(13, 'Đồng hồ thụy sĩ'),
(14, 'Đồng hồ cao cấp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `order_id` int NOT NULL,
  `customer_id` int DEFAULT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recipient_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `recipient_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `recipient_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `status` int DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`order_id`, `customer_id`, `order_date`, `recipient_name`, `recipient_address`, `recipient_phone`, `note`, `total_price`, `status`, `payment_method`) VALUES
(42, 18, '2024-05-18 16:15:48', 'thanh', '2001216141 au cơ, Xã Trung Trực, Huyện Yên Sơn, Tỉnh Tuyên Quang', '0144785237', 'không có ai nhà, thì gửi hàng xóm', 5559660000, 1, 'Chuyển khoản'),
(43, 18, '2024-05-18 18:12:24', 'blog_db_admin', '2001216141 au cơ, Xã Yên Giả, Huyện Quế Võ, Tỉnh Bắc Ninh', '0144785236', '', 70325000, 0, 'Tiền mặt'),
(44, 18, '2024-05-18 19:50:08', 'Hồ Minh Quang', '456 Lạc Long Quân, Xã Vân Hồ, Huyện Vân Hồ, Tỉnh Sơn La', '0123456789', '', 18255000, 1, 'Tiền mặt'),
(45, NULL, '2024-05-18 19:55:44', ' yennh', 'sdadad, Xã Đại Đồng, Huyện Tiên Du, Tỉnh Bắc Ninh', '0741852369', '', 51565000, 1, 'Tiền mặt'),
(46, NULL, '2024-05-19 06:54:00', 'Phan Thế Thanh', '456 Âu Cơ, Xã Đức Long, Huyện Quế Võ, Tỉnh Bắc Ninh', '0987456123', '', 90485000, 1, 'Chuyển khoản'),
(47, 28, '2024-05-21 03:57:16', 'David', '789 Lạc Long Quân , Xã Thái Hòa, Huyện Hàm Yên, Tỉnh Tuyên Quang', '0123456789', '', 2220996000, 1, 'Tiền mặt'),
(49, 18, '2024-05-24 00:34:18', 'Thanh cute', '789 Lạc Long Quân , Xã Yên Hoa, Huyện Na Hang, Tỉnh Tuyên Quang', '0456789233', '', 86124000, 0, 'Tiền mặt'),
(50, 29, '2024-05-24 00:40:15', 'Thanh đáng iu', '456 Âu Cơ , Xã Minh Hạc, Huyện Hạ Hoà, Tỉnh Phú Thọ', '0987124563', 'Không có ai nhà thì gửi hàng xóm', 456025000, 1, 'Chuyển khoản'),
(51, 18, '2024-05-24 18:47:20', 'David', '789 Lạc Long Quân , 02254, 072, 08', '0456789255', '', 6085000, 0, 'Tiền mặt'),
(52, 23, '2024-05-24 22:54:40', 'James', '123 Điện Biên Phủ, Xã Quảng Minh, Huyện Việt Yên, Tỉnh Bắc Giang', '0145963287', '', 3360985000, 1, 'Tiền mặt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(42, 2, 2, 6085000),
(42, 9, 1, 8500000),
(42, 34, 5, 1107798000),
(43, 28, 2, 15685000),
(43, 29, 3, 12985000),
(44, 2, 3, 6085000),
(45, 1, 4, 5285000),
(45, 2, 5, 6085000),
(46, 1, 1, 5285000),
(46, 32, 3, 28400000),
(47, 8, 2, 2700000),
(47, 34, 2, 1107798000),
(49, 44, 3, 9668000),
(49, 46, 4, 14280000),
(50, 2, 7, 6085000),
(50, 4, 3, 6085000),
(50, 9, 8, 8500000),
(50, 26, 2, 87687500),
(50, 31, 2, 58500000),
(50, 43, 1, 34800000),
(51, 4, 1, 6085000),
(52, 4, 3, 6085000),
(52, 34, 3, 1107798000),
(52, 44, 2, 9668000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_price` decimal(10,0) NOT NULL,
  `product_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brand_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_description`, `product_image`, `brand_id`, `category_id`) VALUES
(1, 'Đồng Hồ Calvin Klein Quartz 35mm Unisex', 5285000, 'Đồng hồ Calvin Klein Quartz 35mm Unisex là một chiếc đồng hồ thời trang đơn giản và thanh lịch, phù hợp cho cả nam và nữ. Với mặt số có đường kính 35mm, đồng hồ này có kích thước vừa phải, dễ dàng kết hợp với nhiều loại trang phục khác nhau', 'Calvin Klein-1.png', 24, 4),
(2, 'Đồng Hồ Calvin Klein Quartz 40mm Unisex', 6085000, 'Đồng hồ Calvin Klein Quartz 35mm Unisex là một chiếc đồng hồ thời trang đơn giản và thanh lịch, phù hợp cho cả nam và nữ. Với mặt số có đường kính 35mm, đồng hồ này có kích thước vừa phải, dễ dàng kết hợp với nhiều loại trang phục khác nhau', 'Calvin Klein-2.png', 24, 4),
(3, 'Đồng Hồ Unisex Movado Bold Evolution 2.0 40mm ', 15285000, 'Đồng hồ CITIZEN EM0896-89Y dành cho nữ có một thiết kế đẹp mắt và sang trọng. Với đường kính 30.5 mm, nó mang lại sự tinh tế và thanh lịch cho người đeo.', 'Movado.png', 26, 4),
(4, 'Đồng Hồ Calvin Klein Quartz 35mm Unisex', 6085000, 'Đồng Hồ Calvin Klein Quartz 35mm Unisex: Sự Tinh Tế và Thanh Lịch Đích Thực', 'Calvin Klein.png', 24, 4),
(5, 'Đồng Hồ Unisex Movado Bold Evolution 2.0  40mm', 18285000, 'Đồng Hồ Unisex Movado Bold Evolution 2.0 40mm là biểu tượng của sự tiến bộ và cá nhân hóa trong thế giới đồng hồ. Với thiết kế táo bạo và đầy mạnh mẽ, chiếc đồng hồ này mang lại một phong cách hiện đại và độc đáo cho người đeo.', 'Movado-1.png', 26, 4),
(6, 'Đồng Hồ Unisex Citizen Eco-Drive Octangle  38mm', 7985000, 'Đồng Hồ Unisex Citizen Eco-Drive Octangle 38mm là một sự kết hợp hoàn hảo giữa phong cách và công nghệ tiên tiến. Với thiết kế hình bát giác độc đáo và tinh tế, chiếc đồng hồ này tạo ra một dấu ấn độc đáo và cá nhân', 'Citizen.png', 5, 4),
(7, 'Đồng Hồ Bulova Quartz  45mm Nam', 11815000, 'Đồng Hồ Bulova Quartz 45mm Nam là một biểu tượng của phong cách và đẳng cấp. Với thiết kế mạnh mẽ và nam tính, chiếc đồng hồ này là điểm nhấn hoàn hảo cho bất kỳ bộ trang phục nào.', 'Bulova.png', 16, 10),
(8, 'Đồng Hồ Citizen Quartz 40mm Nam', 2700000, 'Đồng Hồ Citizen Quartz 40mm Nam là một lựa chọn tuyệt vời cho những quý ông muốn kết hợp giữa phong cách hiện đại và tính chính xác. Với đường kính 40mm, chiếc đồng hồ này đủ lớn để tạo điểm nhấn mạnh mẽ trên cổ tay,', 'Citizen-1.png', 5, 10),
(9, 'Đồng Hồ Citizen Eco-Drive 45mm Nam', 8500000, 'Đồng Hồ Citizen Eco-Drive 45mm Nam là một sự kết hợp hoàn hảo giữa phong cách, độ chính xác và tính tiện ích. Với đường kính lớn là 45mm, chiếc đồng hồ này tạo nên một sự hiện đại và mạnh mẽ khi đeo trên cổ tay.', 'Citizen-2.png', 5, 10),
(11, 'Đồng Hồ Citizen Eco-Drive 42.5mm Nam', 13885000, 'Đồng Hồ Citizen Eco-Drive 42.5mm dành cho nam là một lựa chọn xuất sắc cho những quý ông yêu thích sự tiện ích và đẳng cấp. Với đường kính lớn là 42.5mm, chiếc đồng hồ này tạo ra một vẻ ngoài mạnh mẽ và nam tính trên cổ tay.', 'Citizen-3.png', 5, 10),
(25, 'Đồng Hồ Citizen Eco-Drive 42mm Nam', 5800000, 'Đồng Hồ Citizen Eco-Drive 42mm Nam là một sự lựa chọn hoàn hảo cho những quý ông muốn kết hợp giữa phong cách và tính năng tiện ích. Với đường kính mặt đồng hồ là 42mm, nó tạo ra một vẻ ngoài nam tính và mạnh mẽ trên cổ tay.', 'Citizen-4.png', 5, 10),
(26, 'Đồng Hồ Nữ Longines Master Collection 29mm', 87687500, 'Đồng Hồ Nữ Longines Master Collection 29mm là một sự kết hợp hoàn hảo giữa sự thanh lịch, sang trọng và đẳng cấp. Với đường kính mặt đồng hồ là 29mm, nó tạo ra một vẻ ngoài tinh tế và nữ tính trên cổ tay.', 'Longines-1.png', 2, 5),
(27, 'Đồng Hồ Nữ Citizen L Arcly Eco-Drive 31.2mm', 22085000, 'Đồng Hồ Nữ Citizen L Arcly Eco-Drive 31.2mm là biểu tượng của sự thanh lịch và tinh tế. Với thiết kế tròn và mặt số màu trắng trang nhã, nó tạo ra một vẻ đẹp tinh tế và sang trọng trên cổ tay của phái đẹp.', 'Citizen-5.png', 5, 5),
(28, 'Đồng Hồ Bulova Automatic 34mm Nữ', 15685000, 'Đồng Hồ Bulova Automatic 34mm dành cho phụ nữ là một biểu tượng của sự đẳng cấp và độ chính xác. Với thiết kế tròn và mặt số màu đen thanh lịch, nó tạo ra một vẻ đẹp tinh tế và sang trọng trên cổ tay của phái đẹp.', 'Bulova-1.png', 16, 5),
(29, 'Đồng Hồ Nữ Bulova Classic Surveyor 34mm', 12985000, 'Đồng hồ Bulova Classic Surveyor 34mm dành cho phụ nữ mang trong mình sự thanh lịch và tinh tế của thương hiệu Bulova. Với mặt số tròn trắng sáng và vỏ thép không gỉ, nó tạo ra một vẻ đẹp đơn giản nhưng không kém phần sang trọng.', 'Bulova-2.png', 16, 5),
(30, 'Đồng Hồ Bulova Quartz 43mm Nam', 11985000, 'Đồng hồ Bulova Quartz 43mm dành cho nam giới là một sự kết hợp tuyệt vời giữa phong cách hiện đại và tính năng đáng tin cậy. Với vỏ thép không gỉ chắc chắn và mặt số tròn lớn, nó tạo ra một diện mạo mạnh mẽ và nam tính.', 'Bulova-3.png', 16, 5),
(31, 'Longines - Nam L2.821.5.57.7 Size 40mm', 58500000, 'Đồng hồ Longines dành cho nam mã L2.821.5.57.7 có kích thước mặt đồng hồ là 40mm, mang đến sự hoàn thiện và sang trọng cho cổ tay của bạn. Với thiết kế tinh tế và đẳng cấp.', 'Longines.png', 2, 14),
(32, 'Longines - Nam L4.921.2.42.7 Size 38.5mm', 28400000, 'Đồng hồ Longines dành cho nam mã L4.921.2.42.7 có kích thước mặt đồng hồ là 38.5mm, mang đến sự thanh lịch và sang trọng cho cổ tay của bạn. Với vỏ và dây đeo bằng thép không gỉ, chiếc đồng hồ này kết hợp giữa sự đẳng cấp và tính thực dụng.', 'Longines-2.png', 2, 14),
(33, 'Longines - Nam L2.820.4.57.2 Size 38.5mm', 44500000, 'Đồng hồ Longines nam mã L2.820.4.57.2 có kích thước mặt đồng hồ là 38.5mm, tạo nên một sự hoàn hảo vừa vặn trên cổ tay của bạn. Với vỏ và dây đeo được làm từ thép không gỉ, đồng hồ này kết hợp giữa sự bền bỉ và đẳng cấp.', 'Longines-3.png', 2, 14),
(34, 'Đồng hồ Rolex nam Day-Date 40', 1107798000, 'Đồng hồ Rolex nam Day-Date 40 là biểu tượng của sự thanh lịch và sang trọng. Với kích thước 40mm. Vỏ và dây đeo được làm từ các loại kim loại quý như vàng 18k hoặc bạch kim cao cấp, tạo ra sự sang trọng và đẳng cấp.', 'Rolex.png', 1, 14),
(40, 'Đồng Hồ Cặp Movado Museum Classic', 11900000, 'Đồng Hồ Cặp Movado Museum Classic là một chiếc đồng hồ sang trọng và lịch lãm, mang lại phong cách đẳng cấp cho người đeo. Thiết kế đơn giản nhưng không kém phần tinh tế, với mặt đồng hồ tròn phủ lớp kính sapphire chống trầy và chống ánh sáng', 'Movado-4.png', 26, 3),
(41, 'Đồng Hồ Cặp Movado Bold Verso', 31954643, 'Đồng Hồ Cặp Movado Bold Verso là một chiếc đồng hồ sang trọng và đẳng cấp dành cho cặp đôi yêu thích phong cách thời trang và hiện đại. Thiết kế của đồng hồ này rất ấn tượng với mặt số tròn lớn, dây đeo da chất lượng cao và màu sắc độc đáo.', 'Movado-5.png', 26, 3),
(42, 'Đồng Hồ Cặp Longines Lyre', 25000000, 'Đồng Hồ Cặp Longines Lyre là một dòng đồng hồ cao cấp của thương hiệu Longines, một trong những thương hiệu đồng hồ hàng đầu thế giới. Đồng hồ Longines Lyre có thiết kế đẹp mắt, sang trọng và độc đáo, với các chi tiết tinh xảo và hoàn thiện tỉ mỉ.', 'Longines-4.png', 2, 3),
(43, 'Đồng Hồ Cặp Longines Elegant', 34800000, 'Đồng hồ Longines Elegant là một trong những dòng sản phẩm đẳng cấp của hãng đồng hồ nổi tiếng Longines. Với thiết kế đẹp mắt, sang trọng và tinh tế, đồng hồ Longines Elegant đem đến cho người đeo vẻ đẹp lịch lãm và tinh tế.', 'Longines-5.png', 2, 3),
(44, 'Đồng Hồ Cặp Citizen', 9668000, 'Đồng hồ cặp Citizen không chỉ là một sản phẩm đồng hồ thông thường mà còn là biểu tượng của tình yêu và sự đồng thuận giữa hai người. Chúng thường được chọn làm quà tặng cho người yêu, đối tác đặc biệt trong dịp kỷ niệm, valentine, hoặc ngày cưới.', 'Citizen-6.png', 5, 3),
(45, 'Đồng Hồ Cặp Citizen', 9668000, 'Đồng hồ cặp Citizen không chỉ là một sản phẩm đồng hồ thông thường mà còn là biểu tượng của tình yêu và sự đồng thuận giữa hai người. Chúng thường được chọn làm quà tặng cho người yêu trong dịp kỷ niệm, valentine, hoặc ngày cưới.', 'Citizen-8.png', 5, 3),
(46, 'Đồng Hồ Cặp Bulova Regatta', 14280000, 'Đồng Hồ Cặp Bulova Regatta là một phiên bản đặc biệt của dòng đồng hồ cổ điển từ thương hiệu Bulova. Với thiết kế đẹp mắt và sang trọng, đồng hồ Bulova Regatta là lựa chọn hoàn hảo cho những người yêu thích phong cách cổ điển và thời trang.', 'Bulova-4.png', 16, 3),
(47, 'Casio - Nam MRG-G1000HT-1ADR Size 49.7mm', 112480000, 'Đồng hồ Casio MRG-G1000HT-1ADR không chỉ là một thiết bị đo thời gian, mà còn là một tác phẩm nghệ thuật thể hiện sự kết hợp hoàn hảo giữa công nghệ hiện đại và nghệ thuật chế tác truyền thống Nhật Bản. ', 'Casio-1.png', 3, 14),
(48, 'Đồng Hồ Longines Automatic 40mm Nam', 80500000, 'Đồng hồ Longines Automatic 40mm là một mẫu đồng hồ nam của thương hiệu Longines, một trong những thương hiệu đồng hồ nổi tiếng và uy tín từ Thụy Sĩ. Đồng hồ này có kích thước 40mm phù hợp với cỡ tay nam giới', 'Longines-7.png', 2, 5),
(49, 'Đồng Hồ Citizen Eco-Drive 29.5mm Nữ', 13485000, 'Đồng Hồ Citizen Eco-Drive 29.5mm dành cho nữ là một sản phẩm đẹp và sang trọng. Đồng hồ này có kích thước mặt đồng hồ là 29.5mm, phù hợp với cỡ tay của phái nữ. ', 'Citizen-9.png', 5, 5),
(50, 'Đồng Hồ Longines Quartz 20.4mm Nữ', 106040000, 'Đồng hồ Longines Quartz 20.4mm cho nữ là một lựa chọn tinh tế và sang trọng. Nó có kiểu dáng nhỏ gọn, phù hợp cho cánh đàn bà yêu thích sự thanh lịch và tinh tế trong phong cách.', 'Longines-8.png', 2, 5),
(51, 'Đồng Hồ Bulova Automatic 38.5mm Nam', 74400000, 'Đồng hồ Bulova thường được biết đến với chất lượng và thiết kế đẹp, cùng với việc sử dụng công nghệ tự động (automatic) để hoạt động. Với kích thước 38.5mm, nó có thể phản ánh sự thanh lịch và phong cách đối với người đeo. ', 'Bulova-5.png', 16, 6),
(52, 'Đồng Hồ Bulova Automatic 42mm Nam', 62885000, 'Đồng hồ Bulova Automatic 42mm dành cho nam giới có kích thước mặt đồng hồ là 42mm, làm từ thép không gỉ chất lượng cao, chống nước đến mức độ nhất định.', 'Bulova-6.png', 16, 6),
(53, 'Đồng Hồ Bulova Automatic 42mm Nam', 62885000, 'Đồng Hồ Bulova Automatic 42mm Nam là một sản phẩm đồng hồ được thiết kế dành cho nam giới, có kích thước mặt đồng hồ là 42mm. Đây là một đồng hồ cơ cấu tự động, nghĩa là nó sử dụng chuyển động của cánh trục', 'Bulova-7.png', 16, 6),
(54, 'Đồng Hồ Nam Citizen Series 8 890 Mechanical 40.5mm', 43485000, 'Đồng Hồ Nam Citizen Series 8 890 Mechanical 40.5mm là một sản phẩm đồng hồ cao cấp dành cho nam giới từ thương hiệu Citizen. Với đường kính mặt đồng hồ là 40.5mm, đồng hồ này sử dụng cơ cấu cơ học (mechanical) để hoạt động', 'Citizen-10.png', 5, 6),
(55, 'Đồng Hồ Nữ Longines La Grande Classique 29mm', 47437500, 'Đồng Hồ Nữ Longines La Grande Classique 29mm là một chiếc đồng hồ cổ điển và sang trọng, được thiết kế dành cho phái đẹp. Với đường kính 29mm, nó phù hợp với cỡ tay của phụ nữ và tạo nên vẻ đẹp tinh tế.', 'Longines-9.png', 2, 13),
(56, 'Đồng Hồ Nữ Longines Présence 30mm', 35937500, 'Đồng Hồ Nữ Longines Présence 30mm là một sản phẩm đồng hồ đẳng cấp và đẹp mắt của hãng Longines. Với đường kính mặt đồng hồ là 30mm, nó là phù hợp với cỡ tay của phụ nữ và tạo ra vẻ đẹp thanh lịch và sang trọng.', 'Longines-10.png', 2, 13),
(57, 'Đồng Hồ Nam Movado Heritage Datron Chronograph 41mm', 43085000, 'Đồng Hồ Nam Movado Heritage Datron Chronograph 41mm là một chiếc đồng hồ nam ấn tượng và lịch lãm từ thương hiệu Movado. Với đường kính mặt đồ 41mm, nó thích hợp với cỡ tay trung bình của đàn ông', 'Movado-7.png', 26, 13),
(58, 'Đồng Hồ Nam Movado Heritage Datron Automatic 40mm', 49785000, 'Với thiết kế đẳng cấp và tính năng hoàn hảo, Đồng Hồ Nam Movado Heritage Datron Automatic 40mm là một lựa chọn xuất sắc cho những quý ông muốn sở hữu một chiếc đồng hồ cao cấp và đẳng cấp trong bộ sưu tập của mình.', 'Movado-8.png', 26, 13),
(59, 'Đồng Hồ Nam Movado Bold Fusion Chronograph 44.5mm', 29785000, 'Đồng Hồ Nam Movado Bold Fusion Chronograph 44.5mm là một lựa chọn tuyệt vời cho một chiếc đồng hồ đẹp và chất lượng. Nó thể hiện sự sang trọng và tinh tế của thương hiệu Movado. ', 'Movado-9.png', 26, 13),
(60, 'Đồng Hồ Nam Movado Heritage Datron 40mm', 43085000, 'Đồng Hồ Nam Movado Heritage Datron Automatic 40mm là một chiếc đồng hồ cơ tự động đẹp và đầy cá tính từ Movado. Với thiết kế truyền thống nhưng vẫn hiện đại, chiếc đồng hồ này chắc chắn sẽ là một phần thú vị cho bộ sưu tập của bạn', 'Movado-10.png', 26, 13),
(61, 'Casio MTP-1375L-7AVDF', 2270000, 'Đồng hồ Casio MTP-1375L-7AVDF là một mẫu đồng hồ nam với dây đeo da và thiết kế analog cổ điển. Nó có màn hình hiển thị ngày và tháng, cũng như một cấu trúc vỏ bằng hợp kim cho độ bền.', 'Casio-2.png', 3, 12),
(62, 'Rolex nam COSMOGRAPH DAYTONA', 2034619500, 'Rolex Cosmograph Daytona là một trong những mẫu đồng hồ nổi tiếng và được ưa chuộng của Rolex. Được giới thiệu lần đầu vào năm 1963, mẫu Daytona được thiết kế đặc biệt tính năng chronograph đầy mạnh mẽ và chính xác', 'Rolex-4.png', 1, 14),
(63, 'Rolex YACHT-MASTER II - Nam', 1137961000, 'Đồng hồ Rolex Yacht-Master II là một sản phẩm dành cho nam giới. Được ra mắt vào năm 2007, Yacht-Master II được thiết kế đặc biệt cho các thủy thủ chuyên nghiệp và người yêu thể thao nước.', 'Rolex-5.png', 1, 14),
(64, 'Rolex YACHT-MASTER 37 - Nữ', 386632500, 'Rolex Yacht-Master 37 là một mẫu đồng hồ cao cấp của hãng Rolex với thiết kế thanh lịch và mang đậm tinh thần biển khơi.', 'Rolex-7.png', 1, 14),
(65, 'Rolex YACHT-MASTER II - Nam 44 mm', 663582500, 'Rolex Yacht-Master là một mẫu đồng hồ cao cấp của hãng Rolex với thiết kế thanh lịch và mang đậm tinh thần biển khơi. Dù kích thước 44mm thường được xem là phù hợp với cánh đàn ông do đường kính trung bình của nó.', 'Rolex-9.png', 1, 14),
(66, 'Rolex SEA-DWELLER - Nam', 485347500, 'Vành đồng hồ xoay một chiều có vạch chia 60 phút của Sea-Dweller cho phép các thợ lặn giám sát số lần lặn và giải nén của họ một cách chính xác và an toàn. Nó được trang bị với vòng số vành Cerachrom màu đen đã được cấp bằng sáng chế do Rolex sản xuất', 'Rolex-10.png', 1, 14),
(67, 'Rolex 1908 - Nam', 586804000, 'Mỗi mặt đồng hồ là một tác phẩm nghệ thuật thu nhỏ. Màu sắc, độ phản chiếu và kết cấu bề mặt, cùng các yếu tố trang trí và thiết kế tổng thể, tất cả mang đến cho mỗi chiếc đồng hồ đặc trưng riêng biệt', 'Rolex-11.png', 1, 14),
(68, 'Rolex GMT-MASTER II - Nam', 1083119500, 'Mẫu đồng hồ này đi kèm mặt số màu xanh đen. Ngoài các kim giờ, phút và giây thông thường, phiên bản GMT-Master II được trang bị một kim đầu mũi tên, di chuyển hết một vòng mặt đồng hồ mỗi 24 giờ', 'Rolex-13.png', 1, 14),
(69, 'Rolex EXPLORER II - Nữ', 257755000, 'Phiên bản Explorer II được trang bị thêm màn hình phụ hiển thị 24 giờ; một kim chuyên dụng quay vòng quanh mặt số trong 24 giờ chứ không phải là 12 giờ thông thường, hướng đến vành đồng hồ cố định với vạch chia 24 giờ', 'Rolex-14.png', 1, 14),
(70, 'Đồng hồ Hublot Big Bang King Gold - Nam', 550000000, 'Đồng hồ Hublot Big Bang King Gold 41mm là một biểu tượng của sự sang trọng và đẳng cấp trong thế giới đồng hồ cao cấp, phản ánh sự tinh tế và sự đam mê về công nghệ và thiết kế của Hublot.', 'Hublot.png', 4, 14),
(71, 'Đồng hồ Hublot Big Bang Diamonds 41mm - Nam', 660000000, 'Đồng hồ Hublot Big Bang Gold Diamonds 41mm là biểu tượng của sự xa hoa và đẳng cấp với việc kết hợp giữa vàng và kim cương, là sự lựa chọn hoàn hảo cho những ai yêu thích sự sang trọng và lấp lánh trong phong cách cá nhân của mình.', 'Hublot-1.png', 4, 14),
(72, 'Đồng Hồ Hublot Classic Fusion - Nam', 338000000, 'Đồng hồ Hublot Classic Fusion Automatic King Gold 42mm là biểu tượng của sự tinh tế và đẳng cấp, là lựa chọn hoàn hảo cho những ai yêu thích sự sang trọng và tính hiện đại trong phong cách cá nhân của mình.', 'Hublot-2.png', 4, 14),
(73, 'Đồng hồ Longines HydroConquest Nam', 47438000, 'Đồng hồ Longines HydroConquest Nam là một sự kết hợp hoàn hảo giữa phong cách thể thao và đẳng cấp, mang lại cho người đeo sự tự tin và phong cách đầy nam tính.', 'Longines-11.png', 2, 13),
(74, 'Đồng hồ Longines Master Nữ ', 63250000, 'Đồng hồ Longines Master dành cho nữ là biểu tượng của sự tinh tế và đẳng cấp, là lựa chọn hoàn hảo cho những phụ nữ yêu thích phong cách thanh lịch và sang trọng.', 'Longines-12.png', 2, 6),
(75, 'Đồng Hồ Cặp Longines', 77625000, 'Đồng hồ cặp Longines là một biểu tượng của sự lãng mạn và tình yêu, được thiết kế đặc biệt để thể hiện sự gắn kết và đồng thuận giữa hai người', 'Longines-13.png', 2, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `phone`, `role`) VALUES
(18, 'Then@gmail.com', '$2y$10$n95X.9u5l9L38Wy8TzgdduNUlkLba5pUrJzBUd3s8HHW9Z7EvO1GC', 'admin', '0741852369', 'admin'),
(22, 'Thanh123@gmail.com', '$2y$10$QMmd8TxpAwmjPyBt7kfuXOP8H0SN89.JFDwdP5t/IVE1U76mgxizq', 'Phan Thế Thanh', '0123456789', 'user'),
(23, 'Thanh@gmail.com', '$2y$10$H1GsZcwnD8gZIy8jTHpt.e4zLQ2oyx/aQXHO9wzckn.0.yczgM2T.', 'Thanh dzai', '0784512369', 'user'),
(24, 'eqw@gmail.com', '$2y$10$vFvpbBMgLi6GUrVLA9XPj.5yn3sdGME3twmg6g3swX1uk5nZ2IfOa', ' yennh', '0986532147', 'user'),
(27, 'aaaaaaa@gmail.com', '$2y$10$41vLCAos.Mh9ljGGRBSpXurZp2M3caHP/2ChioLs9wFBu.qs.4O9u', 'qqqqqqqq', '0147852369', 'user'),
(28, 'Minh@gmail.com', '$2y$10$19PzwOwc75Cld35CSFAty.AkK2En8RsYs20vKatxxSVVoQVY9QdEG', 'VM', '0456789231', 'admin'),
(29, 'phanthethanh0209@gmail.com', '$2y$10$sHWLZu9MTSRSxm12lzZAN.e59qo9SOMB1G9zCNA0ArfNIjjjWOd1m', 'Thanh cute', '0456987123', 'user'),
(30, 'David@gmail.com', '$2y$10$WeAsiQrudJmYftIIXu/Sou/HdawUaVjXoidB4bkcLXF0EcNNMGU/e', 'David', '0978512365', 'user'),
(31, 'mydb_admin@gmail.com', '$2y$10$A/AdFAi8oQ72x9tyhpb2MeeEa/SCIp2Y3iHo0zamInUy0qXwzwZJG', 'Thanh cute', '0145962387', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`customer_id`,`product_id`),
  ADD KEY `cart_ibfk_2` (`product_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `order_detail_ibfk_2` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
