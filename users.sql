CREATE temp TABLE users(id BIGSERIAL, group_id BIGINT);
INSERT INTO users(group_id) VALUES (1), (1), (1), (2), (1), (3);
SELECT min_id, group_id FROM (SELECT CASE WHEN group_id = LAG(group_id) OVER (ORDER BY id) THEN NULL ELSE id END AS min_id, group_id FROM users )AS sub WHERE min_id IS NOT NULL