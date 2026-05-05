CREATE DATABASE IF NOT EXISTS progetto_php;
USE progetto_php;

CREATE TABLE CLIENTE (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Cognome VARCHAR(100) NOT NULL,
    Indirizzo VARCHAR(255),
    Email VARCHAR(100) NOT NULL UNIQUE,
    Telefono VARCHAR(20),
    Password VARCHAR(255) NOT NULL
);

CREATE TABLE Categoria (
    nome_categoria VARCHAR(50) PRIMARY KEY
);

CREATE TABLE DISPOSITIVO (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    Modello VARCHAR(100),
    note_caratteristiche TEXT,
    Prezzo_nuovo DECIMAL(10, 2),
    Data_acquisto DATE,
    Data_produzione DATE
);

CREATE TABLE possiede (
    cliente_id INT,
    dispositivo_id INT,
    PRIMARY KEY (cliente_id, dispositivo_id),
    FOREIGN KEY (cliente_id) REFERENCES CLIENTE(id) ON DELETE CASCADE,
    FOREIGN KEY (dispositivo_id) REFERENCES DISPOSITIVO(id) ON DELETE CASCADE
);

CREATE TABLE appartiene (
    dispositivo_id INT,
    nome_categoria VARCHAR(50),
    PRIMARY KEY (dispositivo_id, nome_categoria),
    FOREIGN KEY (dispositivo_id) REFERENCES DISPOSITIVO(id) ON DELETE CASCADE,
    FOREIGN KEY (nome_categoria) REFERENCES Categoria(nome_categoria) ON DELETE CASCADE
);

CREATE TABLE DIPENDENTE (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    salario_orario DECIMAL(10, 2) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ruolo VARCHAR(20) NOT NULL DEFAULT 'dipendente'
);

CREATE TABLE FATTTURA (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prezzo DECIMAL(10, 2) NOT NULL,
    descrizione TEXT,
    ore_lavoro DECIMAL(10, 2) NOT NULL DEFAULT 0,
    data_creazione DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE riferisce (
    dispositivo_id INT,
    fattura_id INT,
    PRIMARY KEY (dispositivo_id, fattura_id),
    FOREIGN KEY (dispositivo_id) REFERENCES DISPOSITIVO(id) ON DELETE CASCADE,
    FOREIGN KEY (fattura_id) REFERENCES FATTTURA(id) ON DELETE CASCADE
);

CREATE TABLE Crea (
    fattura_id INT,
    dipendente_id INT,
    PRIMARY KEY (fattura_id, dipendente_id),
    FOREIGN KEY (fattura_id) REFERENCES FATTTURA(id) ON DELETE CASCADE,
    FOREIGN KEY (dipendente_id) REFERENCES DIPENDENTE(id) ON DELETE CASCADE
);

CREATE TABLE COMPONENTE (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    prezzo DECIMAL(10, 2) NOT NULL,
    disponibilita INT DEFAULT 0
);

CREATE TABLE usa (
    fattura_id INT,
    componente_id INT,
    quantita INT DEFAULT 1,
    PRIMARY KEY (fattura_id, componente_id),
    FOREIGN KEY (fattura_id) REFERENCES FATTTURA(id) ON DELETE CASCADE,
    FOREIGN KEY (componente_id) REFERENCES COMPONENTE(id) ON DELETE CASCADE
);

CREATE INDEX idx_cliente_email ON CLIENTE(Email);
CREATE INDEX idx_dipendente_email ON DIPENDENTE(email);
CREATE INDEX idx_dipendente_ruolo ON DIPENDENTE(ruolo);
CREATE INDEX idx_fattura_data ON FATTTURA(data_creazione);
