INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES
('Marc', 'Quizon', 'marc_lesley_quizon@dlsu.edu.ph', '1234', 'Student'),
('Angelo', 'Almeda', 'angelo_almeda@dlsu.edu.ph', '1234', 'Student'),
('Carl', 'Crespo', 'carl_crespo@dlsu.edu.ph', '1234', 'Staff'),
('Nathan', 'Saclolo', 'nathan_saclolo@dlsu.edu.ph', '1234', 'Staff').
('Daniel', 'Pamintunuan', 'daniel_pamintunuan@dlsu.edu.ph', '1234', 'Admin');

INSERT INTO categories (name) VALUES
('Electronics'),
('Tumblers & Bottles'),
('Wallets'),
('Documents'),
('Apparel & Bags'),
('Others');

INSERT INTO brands (name) VALUES
('Apple'),
('Samsung'),
('Huawei'),
('JisuLife'),
('Goojodoq'),
('Anker'),
('AquaFlask'),
('Hydro Flask'),
('Gucci'),
('Louis Vuitton'),
('Coach'),
('Uniqlo'),
('Zara'),
('H&M'),
('none');

INSERT INTO category_brands (category_id, brand_id) VALUES
-- Electronics (category_id: 1) -> Apple, Samsung, Huawei, JisuLife, Goojodoq, Anker
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
-- Tumblers & Bottles (category_id: 2) -> AquaFlask, Hydro Flask, none
(2, 7), (2, 8), (2, 15),
-- Wallets (category_id: 3) -> Gucci, Louis Vuitton, Coach, none
(3, 9), (3, 10), (3, 11), (3, 15),
-- Documents (category_id: 4) -> none
(4, 15),
-- Apparel & Bags (category_id: 5) -> Gucci, Louis Vuitton, Coach, Uniqlo, Zara, H&M, none
(5, 9), (5, 10), (5, 11), (5, 12), (5, 13), (5, 14), (5, 15),
-- Others (category_id: 6) -> Maps to all for flexibility, or just none
(6, 15);

INSERT INTO buildings (name, abbreviation, max_level) VALUES
('St. La Salle Hall', 'LS', 4),
('Yuchengco Hall', 'Y', 9),
('Br. Connon Hall', 'BC', 5),
('St. Joseph Hall', 'SJ', 6),
('St. Miguel Hall', 'SM', 5),
('St. Mutien Marie Hall', 'MM', 4),
('William Hall', 'WH', 4)
('Henry Sy Sr. Hall', 'HSSH', 14),
('Velasco Hall', 'V', 5),
('Science and Technology Center', 'STR', 5),
('Gokongwei Hall', 'G', 4),
('Andrew Gonzalez Hall', 'AG', 21),
('Enrique Razon Sports Center', 'ER', 10)
('Bloemen Hall', 'BH', 4);


INSERT INTO rooms (name, building_id, level) VALUES
-- =========================================================================
-- St. La Salle Hall (building_id: 1, max_level: 4) 
-- =========================================================================
('LS101', 1, 1), ('LS102', 1, 1), ('LS103', 1, 1), ('LS104', 1, 1), ('LS105', 1, 1),
('LS201', 1, 2), ('LS202', 1, 2), ('LS203', 1, 2), ('LS204', 1, 2), ('LS205', 1, 2),
('LS301', 1, 3), ('LS302', 1, 3), ('LS303', 1, 3), ('LS304', 1, 3), ('LS305', 1, 3),

-- =========================================================================
-- Yuchengco Hall (building_id: 2, max_level: 9) 
-- =========================================================================
('Y201', 2, 2), ('Y202', 2, 2), ('Y203', 2, 2), ('Y204', 2, 2), ('Y205', 2, 2),
('Y301', 2, 3), ('Y302', 2, 3), ('Y303', 2, 3), ('Y304', 2, 3), ('Y305', 2, 3),
('Y401', 2, 4), ('Y402', 2, 4), ('Y403', 2, 4), ('Y404', 2, 4), ('Y405', 2, 4),
('Y501', 2, 5), ('Y502', 2, 5), ('Y503', 2, 5), ('Y504', 2, 5), ('Y505', 2, 5),
('Y601', 2, 6), ('Y602', 2, 6), ('Y603', 2, 6), ('Y604', 2, 6), ('Y605', 2, 6),
('Y701', 2, 7), ('Y702', 2, 7), ('Y703', 2, 7), ('Y704', 2, 7), ('Y705', 2, 7),

-- Br. Connon Hall (building_id: 3)
('Waldo Perfecto Seminar Room', 3, 1),
('Green Media Group Member Lounge', 3, 5),

-- =========================================================================
-- St. Joseph Hall (building_id: 4, max_level: 6) 
-- =========================================================================
('SJ101', 4, 1), ('SJ102', 4, 1), ('SJ103', 4, 1), ('SJ104', 4, 1), ('SJ105', 4, 1),
('SJ201', 4, 2), ('SJ202', 4, 2), ('SJ203', 4, 2), ('SJ204', 4, 2), ('SJ205', 4, 2),
('SJ301', 4, 3), ('SJ302', 4, 3), ('SJ303', 4, 3), ('SJ304', 4, 3), ('SJ305', 4, 3),
('SJ401', 4, 4), ('SJ402', 4, 4), ('SJ403', 4, 4), ('SJ404', 4, 4), ('SJ405', 4, 4),
('SJ501', 4, 5), ('SJ502', 4, 5), ('SJ503', 4, 5), ('SJ504', 4, 5), ('SJ505', 4, 5),
('SJ601', 4, 6), ('SJ602', 4, 6), ('SJ603', 4, 6), ('SJ604', 4, 6), ('SJ605', 4, 6),

-- =========================================================================
-- St. Miguel Hall (building_id: 5, max_level: 5) 
-- =========================================================================
('SM101', 5, 1), ('SM102', 5, 1), ('SM103', 5, 1), ('SM104', 5, 1), ('SM105', 5, 1),
('SM201', 5, 2), ('SM202', 5, 2), ('SM203', 5, 2), ('SM204', 5, 2), ('SM205', 5, 2),
('SM301', 5, 3), ('SM302', 5, 3), ('SM303', 5, 3), ('SM304', 5, 3), ('SM305', 5, 3),
('SM401', 5, 4), ('SM402', 5, 4), ('SM403', 5, 4), ('SM404', 5, 4), ('SM405', 5, 4),
('SM501', 5, 5), ('SM502', 5, 5), ('SM503', 5, 5), ('SM504', 5, 5), ('SM505', 5, 5),

-- =========================================================================
-- St. Mutien Marie Hall (building_id: 6, max_level: 4) 
-- =========================================================================
('MM101', 6, 1), ('MM102', 6, 1), ('MM103', 6, 1), ('MM104', 6, 1), ('MM105', 6, 1),
('MM201', 6, 2), ('MM202', 6, 2), ('MM203', 6, 2), ('MM204', 6, 2), ('MM205', 6, 2),
('MM301', 6, 3), ('MM302', 6, 3), ('MM303', 6, 3), ('MM304', 6, 3), ('MM305', 6, 3),
('MM401', 6, 4), ('MM402', 6, 4), ('MM403', 6, 4), ('MM404', 6, 4), ('MM405', 6, 4),

-- =========================================================================
-- William Hall (building_id: 7, max_level: 4) 
-- =========================================================================
('WH101', 7, 1), ('WH102', 7, 1), ('WH103', 7, 1), ('WH104', 7, 1), ('WH105', 7, 1),
('WH201', 7, 2), ('WH202', 7, 2), ('WH203', 7, 2), ('WH204', 7, 2), ('WH205', 7, 2),
('WH301', 7, 3), ('WH302', 7, 3), ('WH303', 7, 3), ('WH304', 7, 3), ('WH305', 7, 3),
('WH401', 7, 4), ('WH402', 7, 4), ('WH403', 7, 4), ('WH404', 7, 4), ('WH405', 7, 4),

-- =========================================================================
-- Henry Sy Sr. Hall (building_id: 8)
-- =========================================================================
('Pilar Ferrero Lim Room 1', 8, 7), ('Pilar Ferrero Lim Room 2', 8, 7), ('Pilar Ferrero Lim Room 3', 8, 7), ('Pilar Ferrero Lim Room 4', 8, 7), 
('Viewing Room 7E', 8, 7), ('Viewing Room 7F', 8, 7), ('Viewing Room 7G', 8, 7), ('Viewing Room 7H', 8, 7),
('Discussion Room 8A', 8, 8), ('Discussion Room 8B', 8, 8), ('Discussion Room 8G', 8, 8), ('Discussion Room 8H', 8, 8),
('Discussion Room 8C', 8, 8), ('Discussion Room 8D', 8, 8), ('Discussion Room 8E', 8, 8), ('Discussion Room 8F', 8, 8),
('Discussion Room 9A', 8, 9), ('Discussion Room 9B', 8, 9), ('Discussion Room 9C', 8, 9), ('Discussion Room 9D', 8, 9),
('Discussion Room 9E', 8, 9), ('Discussion Room 9F', 8, 9), ('Discussion Room 9G', 8, 9), ('Discussion Room 9H', 8, 9),
('Discussion Room 10A', 8, 10), ('Discussion Room 10B', 8, 10), ('Discussion Room 10G', 8, 10), ('Discussion Room 10C', 8, 10),
('Discussion Room 10D', 8, 10), ('Discussion Room 10E', 8, 10),
('Discussion Room 12A', 8, 12), ('Discussion Room 12B', 8, 12), ('Discussion Room 12G', 8, 12), ('Discussion Room 12H', 8, 12),
('Discussion Room 12C', 8, 12), ('Discussion Room 12D', 8, 12), ('Discussion Room 12E', 8, 12), ('Discussion Room 12F', 8, 12),

-- =========================================================================
-- Velasco Hall (building_id: 9, max_level: 5) 
-- =========================================================================
('V101', 9, 1), ('V102', 9, 1), ('V103', 9, 1), ('V104', 9, 1), ('V105', 9, 1),
('V201', 9, 2), ('V202', 9, 2), ('V203', 9, 2), ('V204', 9, 2), ('V205', 9, 2),
('V301', 9, 3), ('V302', 9, 3), ('V303', 9, 3), ('V304', 9, 3), ('V305', 9, 3),
('V401', 9, 4), ('V402', 9, 4), ('V403', 9, 4), ('V404', 9, 4), ('V405', 9, 4),
('V501', 9, 5), ('V502', 9, 5), ('V503', 9, 5), ('V504', 9, 5), ('V505', 9, 5),

-- =========================================================================
-- Science and Technology Center (building_id: 10, max_level: 5) 
-- =========================================================================
('STR101', 10, 1), ('STR102', 10, 1), ('STR103', 10, 1), ('STR104', 10, 1), ('STR105', 10, 1),
('STR201', 10, 2), ('STR202', 10, 2), ('STR203', 10, 2), ('STR204', 10, 2), ('STR205', 10, 2),
('STR301', 10, 3), ('STR302', 10, 3), ('STR303', 10, 3), ('STR304', 10, 3), ('STR305', 10, 3),
('STR401', 10, 4), ('STR402', 10, 4), ('STR403', 10, 4), ('STR404', 10, 4), ('STR405', 10, 4),
('STR501', 10, 5), ('STR502', 10, 5), ('STR503', 10, 5), ('STR504', 10, 5), ('STR505', 10, 5),

-- =========================================================================
-- Gokongwei Hall (building_id: 11, max_level: 4) 
-- =========================================================================
('G101', 11, 1), ('G102', 11, 1), ('G103', 11, 1), ('G104', 11, 1), ('G105', 11, 1),
('G201', 11, 2), ('G202', 11, 2), ('G203', 11, 2), ('G204', 11, 2), ('G205', 11, 2),
('G301', 11, 3), ('G302', 11, 3), ('G303', 11, 3), ('G304', 11, 3), ('G305', 11, 3),
('G401', 11, 4), ('G402', 11, 4), ('G403', 11, 4), ('G404', 11, 4), ('G405', 11, 4),

-- =========================================================================
-- Andrew Gonzalez Hall (building_id: 12, max_level: 21) 
-- =========================================================================
('AG401', 12, 4), ('AG402', 12, 4), ('AG403', 12, 4), ('AG404', 12, 4), ('AG405', 12, 4),
('AG501', 12, 5), ('AG502', 12, 5), ('AG503', 12, 5), ('AG504', 12, 5), ('AG505', 12, 5),
('AG601', 12, 6), ('AG602', 12, 6), ('AG603', 12, 6), ('AG604', 12, 6), ('AG605', 12, 6),
('AG701', 12, 7), ('AG702', 12, 7), ('AG703', 12, 7), ('AG704', 12, 7), ('AG705', 12, 7),
('AG801', 12, 8), ('AG802', 12, 8), ('AG803', 12, 8), ('AG804', 12, 8), ('AG805', 12, 8),
('AG901', 12, 9), ('AG902', 12, 9), ('AG903', 12, 9), ('AG904', 12, 9), ('AG905', 12, 9),
('AG1001', 12, 10), ('AG1002', 12, 10), ('AG1003', 12, 10), ('AG1004', 12, 10), ('AG1005', 12, 10),
('AG1101', 12, 11), ('AG1102', 12, 11), ('AG1103', 12, 11), ('AG1104', 12, 11), ('AG1105', 12, 11),
('AG1201', 12, 12), ('AG1202', 12, 12), ('AG1203', 12, 12), ('AG1204', 12, 12), ('AG1205', 12, 12),
('AG1301', 12, 13), ('AG1302', 12, 13), ('AG1303', 12, 13), ('AG1304', 12, 13), ('AG1305', 12, 13),
('AG1401', 12, 14), ('AG1402', 12, 14), ('AG1403', 12, 14), ('AG1404', 12, 14), ('AG1405', 12, 14),
('AG1501', 12, 15), ('AG1502', 12, 15), ('AG1503', 12, 15), ('AG1504', 12, 15), ('AG1505', 12, 15),
('AG1601', 12, 16), ('AG1602', 12, 16), ('AG1603', 12, 16), ('AG1604', 12, 16), ('AG1605', 12, 16),
('AG1701', 12, 17), ('AG1702', 12, 17), ('AG1703', 12, 17), ('AG1704', 12, 17), ('AG1705', 12, 17),
('AG1801', 12, 18), ('AG1802', 12, 18), ('AG1803', 12, 18), ('AG1804', 12, 18), ('AG1805', 12, 18),
('AG1901', 12, 19), ('AG1902', 12, 19), ('AG1903', 12, 19), ('AG1904', 12, 19), ('AG1905', 12, 19),
('AG2001', 12, 20), ('AG2002', 12, 20), ('AG2003', 12, 20), ('AG2004', 12, 20), ('AG2005', 12, 20),
('AG2101', 12, 21), ('AG2102', 12, 21), ('AG2103', 12, 21), ('AG2104', 12, 21), ('AG2105', 12, 21),

-- Enrique Razon Sports Center (building_id: 13)
('ER2F', 13, 2), ('ER606', 13, 6), ('ER607', 13, 6), ('ER7A', 13, 7),
('ER7B', 13, 7), ('ER804', 13, 8), ('ER1001', 13, 10), ('ERPOOL', 13, 1), ('Pericos Canteen', 13, 2),

-- Bloemen Hall (building_id: 14)
('Radio Room', 14, 1);


INSERT INTO areas (name, building_id, level) VALUES
-- St. La Salle Hall (building_id: 1)
('Amphitheater', 1, 1),
('LS Benches', 1, 1),
('Pearl of Great Price Chapel', 1, 1),
('Kitchen City', 1, 1),
('Medrano Hall', 1, 2),
('Chapel of the Most Blessed Sacrament', 1, 2),
('Hallway (1st Floor)', 1, 1),
('Hallway (2nd Floor)', 1, 2),
('Hallway (3rd Floor)', 1, 3),
('Male Toilet (1st Floor)', 1, 1), ('Female Toilet (1st Floor)', 1, 1),
('Male Toilet (2nd Floor)', 1, 2), ('Female Toilet (2nd Floor)', 1, 2),
('Male Toilet (3rd Floor)', 1, 3), ('Female Toilet (3rd Floor)', 1, 3),
('Male Toilet (4th Floor)', 1, 4), ('Female Toilet (4th Floor)', 1, 4),

-- Yuchengco Hall (building_id: 2)
('Yuchengco Museum', 2, 2),
('Yuchengco Benches', 2, 1),
('Hallway (2nd Floor)', 2, 2),
('Hallway (3rd Floor)', 2, 3),
('Hallway (4th Floor)', 2, 4),
('Hallway (5th Floor)', 2, 5),
('Hallway (6th Floor)', 2, 6),
('Hallway (7th Floor)', 2, 7),
('Male Toilet (1st Floor)', 2, 1), ('Female Toilet (1st Floor)', 2, 1),
('Male Toilet (2nd Floor)', 2, 2), ('Female Toilet (2nd Floor)', 2, 2),
('Male Toilet (3rd Floor)', 2, 3), ('Female Toilet (3rd Floor)', 2, 3),
('Male Toilet (4th Floor)', 2, 4), ('Female Toilet (4th Floor)', 2, 4),
('Male Toilet (5th Floor)', 2, 5), ('Female Toilet (5th Floor)', 2, 5),
('Male Toilet (6th Floor)', 2, 6), ('Female Toilet (6th Floor)', 2, 6),
('Male Toilet (7th Floor)', 2, 7), ('Female Toilet (7th Floor)', 2, 7),
('Male Toilet (8th Floor)', 2, 8), ('Female Toilet (8th Floor)', 2, 8),
('Male Toilet (9th Floor)', 2, 9), ('Female Toilet (9th Floor)', 2, 9),

-- Br. Connon Hall (building_id: 3)
('Hallway (1st Floor)', 3, 1),
('Hallway (2nd Floor)', 3, 2),
('Hallway (3rd Floor)', 3, 3),
('Hallway (4th Floor)', 3, 4),
('Hallway (5th Floor)', 3, 5),
('Male Toilet (1st Floor)', 3, 1), ('Female Toilet (1st Floor)', 3, 1),
('Male Toilet (2nd Floor)', 3, 2), ('Female Toilet (2nd Floor)', 3, 2),
('Male Toilet (3rd Floor)', 3, 3), ('Female Toilet (3rd Floor)', 3, 3),
('Male Toilet (4th Floor)', 3, 4), ('Female Toilet (4th Floor)', 3, 4),
('Male Toilet (5th Floor)', 3, 5), ('Female Toilet (5th Floor)', 3, 5),

-- St. Joseph Hall (building_id: 4)
('SJ Bench Area (Front)', 4, 1),
('SJ Bench Area (Back)', 4, 1),
('Hallway (1st Floor)', 4, 1),
('Hallway (2nd Floor)', 4, 2),
('Hallway (3rd Floor)', 4, 3),
('Hallway (4th Floor)', 4, 4),
('Hallway (5th Floor)', 4, 5),
('Hallway (6th Floor)', 4, 6),
('Male Toilet (1st Floor)', 4, 1), ('Female Toilet (1st Floor)', 4, 1),
('Male Toilet (2nd Floor)', 4, 2), ('Female Toilet (2nd Floor)', 4, 2),
('Male Toilet (3rd Floor)', 4, 3), ('Female Toilet (3rd Floor)', 4, 3),
('Male Toilet (4th Floor)', 4, 4), ('Female Toilet (4th Floor)', 4, 4),
('Male Toilet (5th Floor)', 4, 5), ('Female Toilet (5th Floor)', 4, 5),
('Male Toilet (6th Floor)', 4, 6), ('Female Toilet (6th Floor)', 4, 6),

-- St. Miguel Hall (building_id: 5)
('Hallway (1st Floor)', 5, 1),
('Hallway (2nd Floor)', 5, 2),
('Hallway (3rd Floor)', 5, 3),
('Hallway (4th Floor)', 5, 4),
('Hallway (5th Floor)', 5, 5),
('Male Toilet (1st Floor)', 5, 1), ('Female Toilet (1st Floor)', 5, 1),
('Male Toilet (2nd Floor)', 5, 2), ('Female Toilet (2nd Floor)', 5, 2),
('Male Toilet (3rd Floor)', 5, 3), ('Female Toilet (3rd Floor)', 5, 3),
('Male Toilet (4th Floor)', 5, 4), ('Female Toilet (4th Floor)', 5, 4),
('Male Toilet (5th Floor)', 5, 5), ('Female Toilet (5th Floor)', 5, 5),

-- St. Mutien Marie Hall (building_id: 6)
('Mutien Ground Floor Lobby', 6, 1),
('Mutien Rear Garden Walkway', 6, 1),
('Hallway (2nd Floor)', 6, 2),
('Hallway (3rd Floor)', 6, 3),
('Hallway (4th Floor)', 6, 4),
('Male Toilet (1st Floor)', 6, 1), ('Female Toilet (1st Floor)', 6, 1),
('Male Toilet (2nd Floor)', 6, 2), ('Female Toilet (2nd Floor)', 6, 2),
('Male Toilet (3rd Floor)', 6, 3), ('Female Toilet (3rd Floor)', 6, 3),
('Male Toilet (4th Floor)', 6, 4), ('Female Toilet (4th Floor)', 6, 4),

-- William Hall (building_id: 7)
('William Hall Ground Floor Lobby', 7, 1),
('Hallway (2nd Floor)', 7, 2),
('Hallway (3rd Floor)', 7, 3),
('Hallway (4th Floor)', 7, 4),
('Male Toilet (1st Floor)', 7, 1), ('Female Toilet (1st Floor)', 7, 1),
('Male Toilet (2nd Floor)', 7, 2), ('Female Toilet (2nd Floor)', 7, 2),
('Male Toilet (3rd Floor)', 7, 3), ('Female Toilet (3rd Floor)', 7, 3),
('Male Toilet (4th Floor)', 7, 4), ('Female Toilet (4th Floor)', 7, 4),

-- Henry Sy Sr. Hall (building_id: 8)
('Cory Aquino Democratic Space (CADS)', 8, 1),
('Outdoor Escalator Area (2nd Floor)', 8, 2),
('Outdoor Escalator Area (3rd Floor)', 8, 3),
('Outdoor Escalator Area (4th Floor)', 8, 4),
('Outdoor Escalator Area (5th Floor)', 8, 5),
('Outdoor Escalator Area (6th Floor)', 8, 6),
('Study Area (6th Floor)', 8, 6),
('Study Area (7th Floor)', 8, 7),
('Study Area (8th Floor)', 8, 8),
('Study Area (9th Floor)', 8, 9),
('Study Area (10th Floor)', 8, 10),
('Study Area (12th Floor)', 8, 12),
('Male Toilet (1st Floor)', 8, 1), ('Female Toilet (1st Floor)', 8, 1),
('Male Toilet (2nd Floor)', 8, 2), ('Female Toilet (2nd Floor)', 8, 2),
('Male Toilet (3rd Floor)', 8, 3), ('Female Toilet (3rd Floor)', 8, 3),
('Male Toilet (4th Floor)', 8, 4), ('Female Toilet (4th Floor)', 8, 4),
('Male Toilet (5th Floor)', 8, 5), ('Female Toilet (5th Floor)', 8, 5),
('Male Toilet (6th Floor)', 8, 6), ('Female Toilet (6th Floor)', 8, 6),
('Male Toilet (7th Floor)', 8, 7), ('Female Toilet (7th Floor)', 8, 7),
('Male Toilet (8th Floor)', 8, 8), ('Female Toilet (8th Floor)', 8, 8),
('Male Toilet (9th Floor)', 8, 9), ('Female Toilet (9th Floor)', 8, 9),
('Male Toilet (10th Floor)', 8, 10), ('Female Toilet (10th Floor)', 8, 10),
('Male Toilet (11th Floor)', 8, 11), ('Female Toilet (11th Floor)', 8, 11),
('Male Toilet (12th Floor)', 8, 12), ('Female Toilet (12th Floor)', 8, 12),

-- Velasco Hall (building_id: 9)
('Outdoor Benches', 9, 1),
('Hallway (1st Floor)', 9, 1),
('Hallway (2nd Floor)', 9, 2),
('Hallway (3rd Floor)', 9, 3),
('Hallway (4th Floor)', 9, 4),
('Hallway (5th Floor)', 9, 5),
('Male Toilet (1st Floor)', 9, 1), ('Female Toilet (1st Floor)', 9, 1),
('Male Toilet (2nd Floor)', 9, 2), ('Female Toilet (2nd Floor)', 9, 2),
('Male Toilet (3rd Floor)', 9, 3), ('Female Toilet (3rd Floor)', 9, 3),
('Male Toilet (4th Floor)', 9, 4), ('Female Toilet (4th Floor)', 9, 4),
('Male Toilet (5th Floor)', 9, 5), ('Female Toilet (5th Floor)', 9, 5),

-- Science and Technology Center (building_id: 10)
('Hallway (1st Floor)', 10, 1),
('Hallway (2nd Floor)', 10, 2),
('Hallway (3rd Floor)', 10, 3),
('Hallway (4th Floor)', 10, 4),
('Hallway (5th Floor)', 10, 5),
('Male Toilet (1st Floor)', 10, 1), ('Female Toilet (1st Floor)', 10, 1),
('Male Toilet (2nd Floor)', 10, 2), ('Female Toilet (2nd Floor)', 10, 2),
('Male Toilet (3rd Floor)', 10, 3), ('Female Toilet (3rd Floor)', 10, 3),
('Male Toilet (4th Floor)', 10, 4), ('Female Toilet (4th Floor)', 10, 4),
('Male Toilet (5th Floor)', 10, 5), ('Female Toilet (5th Floor)', 10, 5),

-- Gokongwei Hall (building_id: 11)
('Gokongwei Ground Floor Lobby', 11, 1),
('Gokongwei Connecting Bridge', 11, 3),
('Hallway (2nd Floor)', 11, 2),
('Hallway (3rd Floor)', 11, 3),
('Hallway (4th Floor)', 11, 4),
('Male Toilet (1st Floor)', 11, 1), ('Female Toilet (1st Floor)', 11, 1),
('Male Toilet (2nd Floor)', 11, 2), ('Female Toilet (2nd Floor)', 11, 2),
('Male Toilet (3rd Floor)', 11, 3), ('Female Toilet (3rd Floor)', 11, 3),
('Male Toilet (4th Floor)', 11, 4), ('Female Toilet (4th Floor)', 11, 4),

-- Andrew Gonzalez Hall (building_id: 12)
('Pericos Canteen', 12, 6),
('Study Lobby Area', 12, 1),
('Hallway (1st Floor)', 12, 1), ('Hallway (6th Floor)', 12, 6), ('Hallway (7th Floor)', 12, 7),
('Hallway (8th Floor)', 12, 8), ('Hallway (9th Floor)', 12, 9), ('Hallway (10th Floor)', 12, 10),
('Hallway (11th Floor)', 12, 11), ('Hallway (12th Floor)', 12, 12), ('Hallway (13th Floor)', 12, 13),
('Hallway (14th Floor)', 12, 14), ('Hallway (15th Floor)', 12, 15), ('Hallway (16th Floor)', 12, 16),
('Hallway (17th Floor)', 12, 17), ('Hallway (18th Floor)', 12, 18),
('Hallway (19th Floor)', 12, 19), ('Hallway (20th Floor)', 12, 20),
('Male Toilet (1st Floor)', 12, 1), ('Female Toilet (1st Floor)', 12, 1),
('Male Toilet (2nd Floor)', 12, 2), ('Female Toilet (2nd Floor)', 12, 2),
('Male Toilet (6th Floor)', 12, 6), ('Female Toilet (6th Floor)', 12, 6),
('Male Toilet (7th Floor)', 12, 7), ('Female Toilet (7th Floor)', 12, 7),
('Male Toilet (8th Floor)', 12, 8), ('Female Toilet (8th Floor)', 12, 8),
('Male Toilet (9th Floor)', 12, 9), ('Female Toilet (9th Floor)', 12, 9),
('Male Toilet (10th Floor)', 12, 10), ('Female Toilet (10th Floor)', 12, 10),
('Male Toilet (11th Floor)', 12, 11), ('Female Toilet (11th Floor)', 12, 11),
('Male Toilet (12th Floor)', 12, 12), ('Female Toilet (12th Floor)', 12, 12),
('Male Toilet (13th Floor)', 12, 13), ('Female Toilet (13th Floor)', 12, 13),
('Male Toilet (14th Floor)', 12, 14), ('Female Toilet (14th Floor)', 12, 14),
('Male Toilet (15th Floor)', 12, 15), ('Female Toilet (15th Floor)', 12, 15),
('Male Toilet (16th Floor)', 12, 16), ('Female Toilet (16th Floor)', 12, 16),
('Male Toilet (17th Floor)', 12, 17), ('Female Toilet (17th Floor)', 12, 17),
('Male Toilet (18th Floor)', 12, 18), ('Female Toilet (18th Floor)', 12, 18),
('Male Toilet (19th Floor)', 12, 19), ('Female Toilet (19th Floor)', 12, 19),
('Male Toilet (20th Floor)', 12, 20), ('Female Toilet (20th Floor)', 12, 20),

-- Enrique Razon Sports Center (building_id: 13)
('9th Floor Basketball Courts', 13, 9),
('9th Floor Bleachers', 13, 9),
('Running Oval', 13, 8),
('7th Floor Basketball Courts', 13, 7),
('7th Floor Table Tennis Area', 13, 7),
('Athletes Gym', 13, 9),
('Male Locker Room (1st Floor)', 13, 1), ('Female Locker Room (1st Floor)', 13, 1),
('Male Toilet (2nd Floor)', 13, 2), ('Female Toilet (2nd Floor)', 13, 2),
('Male Toilet (3rd Floor)', 13, 3), ('Female Toilet (3rd Floor)', 13, 3),
('Male Toilet (4th Floor)', 13, 4), ('Female Toilet (4th Floor)', 13, 4),
('Male Toilet (5th Floor)', 13, 5), ('Female Toilet (5th Floor)', 13, 5),
('Male Toilet (6th Floor)', 13, 6), ('Female Toilet (6th Floor)', 13, 6),
('Male Toilet (7th Floor)', 13, 7), ('Female Toilet (7th Floor)', 13, 7),
('Male Toilet (8th Floor)', 13, 8), ('Female Toilet (8th Floor)', 13, 8),
('Male Toilet (9th Floor)', 13, 9), ('Female Toilet (9th Floor)', 13, 9),
('Male Locker Room (9th Floor)', 13, 9), ('Female Locker Room (9th Floor)', 13, 9),

-- Bloemen Hall (building_id: 14)
('Bloemen Cafeteria Seating Area', 14, 1);