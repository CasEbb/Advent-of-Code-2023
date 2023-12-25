from collections import defaultdict, deque
from pprint import pprint

with open("input") as f:
    content = [x.strip() for x in f.readlines()]
    # content = [int(x) for x in f.readlines()]

hail = []
for stone in content:
    p, v = stone.split(" @ ")
    p = [int(x) for x in p.split(", ")]
    v = [int(x) for x in v.split(", ")]
    hail.append((p, v))


def intersect(a, b):
    ap, av = a
    slope_a = av[1] / av[0]
    bp, bv = b
    slope_b = bv[1] / bv[0]
    if slope_b == slope_a:
        return False, -1, -1
    ayi = ap[1] - slope_a * ap[0]
    byi = bp[1] - slope_b * bp[0]
    x = (byi - ayi) / (slope_a - slope_b)
    y = slope_a * (byi - ayi) / (slope_a - slope_b) + ayi
    return True, x, y


intersections = {}
seen = set()
inside = 0
past = 0
# test = (7, 17)
test = (200000000000000, 400000000000000)
for a, stone1 in enumerate(hail):
    for b, stone2 in enumerate(hail):
        if (a, b) not in seen and (b, a) not in seen and a != b:
            seen.add((a, b))
            valid, x, y = intersect(stone1, stone2)
            # stone1 past
            dx = x - stone1[0][0]
            dy = y - stone1[0][1]
            if (dx > 0) != (stone1[1][0] > 0) or (dy > 0) != (stone1[1][1] > 0):
                valid = False
            dx = x - stone2[0][0]
            dy = y - stone2[0][1]
            if (dx > 0) != (stone2[1][0] > 0) or (dy > 0) != (stone2[1][1] > 0):
                valid = False
            if not valid:
                continue
            if test[0] <= x <= test[1] and test[0] <= y <= test[1]:
                # print(stone1, stone2, valid, x, y)
                inside += 1
            intersections[(a, b)] = test[0] <= x <= test[1] and test[0] <= y <= test[1]

print(inside, past)
