CREATE TABLE Utilisateurs (
    uId INT PRIMARY KEY AUTO_INCREMENT,
    uNom VARCHAR(100) NOT NULL,
    uPrenom VARCHAR(100) NOT NULL,
    uLogin VARCHAR(100) NOT NULL,
    uMdp VARCHAR(100) NOT NULL,
    uEmail VARCHAR(255) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Articles (
    aId INT PRIMARY KEY AUTO_INCREMENT,
    aNom VARCHAR(100) NOT NULL,
    aQuantite INT NOT NULL CHECK (aQuantite >= 0),
    aPrixUnitaire DECIMAL(10, 2) NOT NULL CHECK (aPrixUnitaire >= 0),
    aDateExpiration DATE,
    aImageUrl VARCHAR(255),
    aCommentaire TEXT,
    uId INT,
    FOREIGN KEY (uId) REFERENCES Utilisateurs(uId)
) ENGINE=InnoDB;

CREATE TABLE Transactions (
    tId INT PRIMARY KEY AUTO_INCREMENT,
    tArticleId INT,
    tQuantite INT NOT NULL,
    tDate DATE NOT NULL,
    tType ENUM('ENTREE', 'SORTIE') NOT NULL,
    tCommentaire TEXT,
    uId INT,
    FOREIGN KEY (tArticleId) REFERENCES Articles(aId) ON DELETE CASCADE,
    FOREIGN KEY (uId) REFERENCES Utilisateurs(uId)
) ENGINE=InnoDB;

CREATE TABLE Fournisseurs (
    fId INT PRIMARY KEY AUTO_INCREMENT,
    fNom VARCHAR(100) NOT NULL,
    fApiUrl VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE Alertes (
    alId INT PRIMARY KEY AUTO_INCREMENT,
    alArticleId INT,
    alSeuil INT NOT NULL CHECK (alSeuil > 0),
    FOREIGN KEY (alArticleId) REFERENCES Articles(aId) ON DELETE CASCADE
) ENGINE=InnoDB;
