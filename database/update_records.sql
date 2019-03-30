CREATE TABLE update_records
(
    id INT(255) PRIMARY KEY COMMENT 'The unique ID of the update record (For Database Indexing)' AUTO_INCREMENT,
    public_id VARCHAR(255) COMMENT 'The Public ID (Unique ID) of the update record',
    request_time INT(255) COMMENT 'The Unix Timestamp of when this record was created',
    data MEDIUMTEXT COMMENT 'The data of the update record represented in CSV'
);
CREATE UNIQUE INDEX update_records_id_uindex ON update_records (id);
ALTER TABLE update_records COMMENT = 'Contains a history of Update Records';