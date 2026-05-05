USE progetto_php;

INSERT INTO Categoria (nome_categoria) VALUES
('Smartphone'),
('Tablet'),
('Computer Portatile'),
('Computer Fisso'),
('Console'),
('Elettrodomestico'),
('Audio/Video'),
('Altro');

INSERT INTO COMPONENTE (nome, prezzo, disponibilita) VALUES
('Schermo LCD', 120.00, 15),
('Batteria Li-Ion', 45.00, 30),
('Connettore di ricarica', 8.00, 50),
('Pulsante Home', 5.00, 40),
('Vetro touch', 35.00, 25),
('Ventola raffreddamento', 18.00, 20),
('Alimentatore', 55.00, 10),
('Scheda madre', 200.00, 5),
('Fotocamera posteriore', 65.00, 12),
('Microfono', 12.00, 35),
('Cavo flessibile LCD', 15.00, 28),
('Pasta termica', 3.00, 60),
('Dissipatore CPU', 25.00, 18),
('Porta USB', 4.00, 45),
('Jack audio', 3.50, 55);

INSERT INTO CLIENTE (Nome, Cognome, Indirizzo, Email, Telefono, Password) VALUES
('Mario', 'Rossi', 'Via Roma 10, Lugano', 'mario.rossi@email.com', '0911234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Anna', 'Bianchi', 'Piazza Grande 5, Locarno', 'anna.bianchi@email.com', '0917654321', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Luca', 'Verdi', 'Via Nassa 20, Lugano', 'luca.verdi@email.com', '0912345678', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Sofia', 'Neri', 'Viale Stefano Franscini 1, Bellinzona', 'sofia.neri@email.com', '0918765432', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO DIPENDENTE (nome, salario_orario, email, password, ruolo) VALUES
('Admin', 45.00, 'admin@ti.ch', '$2y$10$nWtBQgvhP1SezDtnpekPROmMOGEXeuEnFl4pA6XJQnhymZwWTN4k6', 'admin'),
('Marco', 35.00, 'marco@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'dipendente');

INSERT INTO DISPOSITIVO (nome, Modello, note_caratteristiche, Prezzo_nuovo, Data_acquisto, Data_produzione) VALUES
('iPhone 14 Pro', 'A2890', 'Smartphone Apple con schermo OLED 6.1", chip A16 Bionic', 1299.00, '2024-09-15', '2024-08-20'),
('Samsung Galaxy S24', 'SM-S921B', 'Smartphone Samsung con schermo Dynamic AMOLED 6.2"', 1099.00, '2025-01-10', '2024-12-15'),
('MacBook Pro 14"', 'M3 Pro', 'Laptop Apple con chip M3 Pro, 18GB RAM, 512GB SSD', 2499.00, '2024-11-20', '2024-10-25'),
('iPad Air 5', 'MM9E3CH/A', 'Tablet Apple con chip M1, 10.9" Liquid Retina', 769.00, '2024-06-05', '2024-04-10'),
('PlayStation 5', 'CFI-1215A', 'Console Sony con SSD 825GB, supporto 4K', 549.00, '2024-12-01', '2024-10-15');

INSERT INTO possiede (cliente_id, dispositivo_id) VALUES
(1, 1),
(1, 3),
(2, 2),
(3, 4),
(4, 5);

INSERT INTO appartiene (dispositivo_id, nome_categoria) VALUES
(1, 'Smartphone'),
(2, 'Smartphone'),
(3, 'Computer Portatile'),
(4, 'Tablet'),
(5, 'Console');
