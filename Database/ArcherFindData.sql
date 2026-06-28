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
-- St. La Salle Hall (building_id: 1)
('LS202', 1, 2),
('LS112', 1, 1),

-- Yuchengco Hall (building_id: 2)
('Y507', 2, 5),
('Y403', 2, 4),

-- Br. Connon Hall (building_id: 3)
('Waldo Perfecto Seminar Room', 3, 1),
('Dental Clinic', 3, 1),

-- St. Joseph Hall (building_id: 4)
('SJ302', 4, 3),
('SJ105', 4, 1),

-- St. Miguel Hall (building_id: 5)
('SM204', 5, 2),
('SM301', 5, 3),

-- St. Mutien Marie Hall (building_id: 6)
('MM102', 6, 1),
('MM201', 6, 2),

-- William Hall (building_id: 7)
('WH211', 7, 2),
('WH304', 7, 3),

-- Henry Sy Sr. Hall (building_id: 8)
('Discussion Room 7A', 8, 7),
('Discussion Room 8F', 8, 8),

-- Velasco Hall (building_id: 9)
('V208', 9, 2),
('V312', 9, 3),

-- Science and Technology Center (building_id: 10)
('STRC104', 10, 1),
('STRC202', 10, 2),

-- Gokongwei Hall (building_id: 11)
('G302', 11, 3),
('G205', 11, 2),

-- Andrew Gonzalez Hall (building_id: 12)
('AG1804', 12, 18),
('AG2002', 12, 20),

-- Enrique Razon Sports Center (building_id: 13)
('ER701', 13, 7),
('ER901', 13, 9),

-- Bloemen Hall (building_id: 14)
('Radio Room', 14, 1),
('Faculty Office', 14, 3);

INSERT INTO areas (name, building_id, level) VALUES
-- St. La Salle Hall (building_id: 1)
('Amphitheater', 1, 1),
('LS Benches', 1, 1),

-- Yuchengco Hall (building_id: 2)
('Yuchengco Museum', 2, 2),
('Yuchengco Benches', 2, 1),

-- Br. Connon Hall (building_id: 3)
('Hallway Area', 3, 1),

-- St. Joseph Hall (building_id: 4)
('SJ Bench Area (Front)', 4, 1),
('SJ Bench Area (Back)', 4, 1),

-- St. Miguel Hall (building_id: 5)
('Hallway', 5, 1),
('Miguel 2nd Floor Study Corner', 5, 2),
--CONTINUE HERE
-- St. Mutien Marie Hall (building_id: 6)
('Mutien Ground Floor Lobby', 6, 1),
('Mutien Rear Garden Walkway', 6, 1),

-- William Hall (building_id: 7)
('William Hall Ground Floor Lobby', 7, 1),
('William 3rd Floor Corridor Seating', 7, 3),

-- Henry Sy Sr. Hall (building_id: 8)
('Henry Sy Ground Floor Amphitheater', 8, 1),
('6th Floor Library CyberSpace Area', 8, 6),

-- Velasco Hall (building_id: 9)
('Velasco Ground Floor Lobby Benches', 9, 1),
('Velasco 4th Floor Study Area', 9, 4),

-- Science and Technology Center (building_id: 10)
('STRC Ground Floor Courtyard', 10, 1),
('STRC 2nd Floor Open Study Lounge', 10, 2),

-- Gokongwei Hall (building_id: 11)
('Gokongwei Ground Floor Lobby', 11, 1),
('Gokongwei 3rd Floor Extension Hallway', 11, 3),

-- Andrew Gonzalez Hall (building_id: 12)
('Andrew 6th Floor Cafeteria Dining Area', 12, 6),
('Andrew 19th Floor Elevator Lobby', 12, 19),

-- Enrique Razon Sports Center (building_id: 13)
('Razon 9th Floor Basketball Courts', 13, 9),
('Razon 8th Floor Badminton Bleachers', 13, 8),

-- Bloemen Hall (building_id: 14)
('Bloemen Cafeteria Seating Area', 14, 1),
('Bloemen 2nd Floor Open Balcony', 14, 2);