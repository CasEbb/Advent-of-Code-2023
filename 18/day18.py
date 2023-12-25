inp = open("input")
dat = inp.read().strip()

pos = (0, 0)
sum1 = 0
sum2 = 0
sum_dir = 0

pos_corr = (0, 0)
sum1_corr = 0
sum2_corr = 0
sum_dir_corr = 0

for l in dat.split("\n"):
    d, n, col = l.split()
    match d:
        case "L":
            direction = (-1, 0)
        case "R":
            direction = (1, 0)
        case "U":
            direction = (0, -1)
        case "D":
            direction = (0, 1)
    length = int(n)
    next_pos = (pos[0] + direction[0] * length, pos[1] + direction[1] * length)
    sum1 = sum1 + (pos[0]) * (next_pos[1])
    sum2 = sum2 + (pos[1]) * (next_pos[0])
    sum_dir += length
    pos = next_pos
    cleaned = col.removeprefix("(#").removesuffix(")")
    corr_len = int(cleaned[:5], base=16)
    match cleaned[5]:
        case "0":
            direction_corr = (1, 0)
        case "1":
            direction_corr = (0, 1)
        case "2":
            direction_corr = (-1, 0)
        case "3":
            direction_corr = (0, -1)
    next_pos_corr = (
        pos_corr[0] + direction_corr[0] * corr_len,
        pos_corr[1] + direction_corr[1] * corr_len,
    )
    sum1_corr = sum1_corr + (pos_corr[0]) * (next_pos_corr[1])
    sum2_corr = sum2_corr + (pos_corr[1]) * (next_pos_corr[0])
    sum_dir_corr += corr_len
    pos_corr = next_pos_corr

area = abs(sum1 - sum2) / 2
print(area + sum_dir / 2 + 1)


area_corr = abs(sum1_corr - sum2_corr) / 2
print(area_corr + sum_dir_corr / 2 + 1)
