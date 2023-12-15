import json


def move(d):
    for _ in range(100):
        d = map(lambda s: s.replace(".O", "O."), d)
    return d


def tilt(d):
    return map("".join, zip(*d))


def load(d):
    return sum(i * (c == "O") for col in d for i, c in enumerate(col[::-1], 1))


print(load(move(tilt(open("input")))))
