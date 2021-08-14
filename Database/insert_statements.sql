INSERT INTO users (user_type, login_name, password, phone, email) VALUES
  ('Employer', 'spotify', 'spotify123456', '4385016383', 'spotify@spotify.com'),
  ('Employer', 'renorun', 'renorun123456', '5145016383', 'renorun@renorun.com'),
  ('Employer', 'busbud', 'busbud123456', '4385026383', 'busbud@busbud.com'),
  ('Recruiter', 'ally_giordino', 'ally123456', '4385016393', 'ally@spotify.com'),
  ('Recruiter', 'karen_banahora', 'karen123456', '4585016383', 'karen@renorun.com'),
  ('Recruiter', 'emily_tetzal', 'emily123456', '4375016383', 'emily@busbud.com'),
  ('Job Seeker', 'dunya_oguz', 'dunyas_password', '6385016383', 'dunya@concordia.ca'),
  ('Job Seeker', 'azman_akhter', 'azmans_password', '4385096383', 'azman@concordia.ca'),
  ('Job Seeker', 'john_purcell', 'johns_password', '4385015383', 'john@concordia.ca');

INSERT INTO memberships (user_type, membership_type, monthly_fee, job_posting_limit, job_application_limit) VALUES
  ('Employer', 'Prime', 50, 5, 0),
  ('Employer', 'Gold', 100, NULL, 0),
  ('Job Seeker', 'Basic', 0, 0, 0),
  ('Job Seeker', 'Prime', 10, 0, 5),
  ('Job Seeker', 'Gold', 20, 0, NULL);

UPDATE users SET status = 'Deactivated' where login_name = 'john_purcell';

INSERT INTO transactions (account_id, transaction_type, amount) VALUES
  (1, 'Charge', -100),
  (2, 'Charge', -50),
  (3, 'Charge', -50),
  (7, 'Charge', -20),
  (8, 'Charge', -10),
  (9, 'Charge', -10);

INSERT INTO transactions (account_id, transaction_type, amount) VALUES
  (1, 'Payment', 200),
  (2, 'Payment', 10),
  (3, 'Payment', 30),
  (4, 'Payment', 27),
  (5, 'Payment', 13),
  (6, 'Payment', 8);

INSERT INTO payment_methods (account_id, payment_method_type, billing_address, postal_code,
                              card_number, security_code, expiration_month, expiration_year) VALUES
  (1, 'Credit', '60 Rue de Bresoles', 'H2Y 1V5', '001836352043266', 677, 09, 2023),
  (2, 'Debit', '1467 Saint Denis Street', 'H2X 3J5', '356799032150000', 098, 12, 2025),
  (3, 'Credit', '2066 Jeanne Mance St', 'H2X 2J5', '9871234099654399', 123, 01, 2022),
  (4, 'Debit', '87 Atwater Avenue', 'H3H 1B5', '997659811304114', 591, 04, 2030),
  (5, 'Credit', '1212 Avenue Des Pins', 'H2W 1S6', '766665098121243', 432, 10, 2022),
  (6, 'Debit', '3665 Rue de Bullion', 'H2X 3A6', '8888076542187610', 404, 07, 2023);

UPDATE payment_methods SET postal_code = 'H2Y 8PO' WHERE account_id = 5;

INSERT INTO employers (user_id, membership_id, name) VALUES
  (1, 2, 'Spotify'),
  (2, 1, 'Renorun'),
  (3, 1, 'Busbud');

INSERT INTO recruiters (user_id, employer_id, first_name, last_name) VALUES
  (4, 1, 'Ally', 'Giordino'),
  (5, 2, 'Karen', 'Banahora'),
  (6, 3, 'Emily', 'Tetzal');

INSERT INTO jobs (employer_id, recruiter_id, title, description, city, province, country) VALUES
  (1, 1, 'Software Engineer', 'This is the best job ever.', 'Montreal', 'QC', 'Canada'),
  (2, 2, 'Data Scientist', 'This job is fun.', 'Toronto', 'ON', 'Canada'),
  (3, 3, 'Engineering Manager', 'This job rocks!', 'New York City', 'New York', 'USA');

INSERT INTO job_seekers (user_id, membership_id, first_name, last_name, city, province, country) VALUES
  (7, 3, 'Dunya', 'Oguz', 'Montreal', 'QC', 'Canada'),
  (8, 4, 'Azman', 'Ahkter', 'Toronto', 'ON', 'Canada'),
  (9, 5, 'John', 'Purcell', 'Hallifax', 'Nova Scotia', 'Canada');

INSERT INTO job_seeker_education_history (job_seeker_id, education_type, school, concentration, grade, year_graduated) VALUES
  (1, 'Diploma', 'Concordia University', 'Computer Science', 3.8, 2022),
  (2, 'Diploma', 'Concordia University', 'Computer Science', 3.5, 2021),
  (3, 'Diploma', 'Concordia University', 'Computer Science', 3.1, 2021);

INSERT INTO applications (job_seeker_id, job_id) VALUES
  (1, 1),
  (2, 3),
  (3, 2);

INSERT INTO administrators (first_name, last_name) VALUES
  ('Dunya', 'Oguz'),
  ('Azman', 'Akhter'),
  ('John', 'Purcell');

UPDATE applications SET status = 'Accepted' WHERE job_seeker_id = 1 AND job_id = 1;
UPDATE jobs SET status = 'Closed' WHERE id = 1;