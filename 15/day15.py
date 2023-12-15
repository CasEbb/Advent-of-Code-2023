def hash(input):
    result = 0
    for char in input:
        result = ((result + ord(char)) * 17) % 256
    return result


instructions = open("input").read().strip().split(",")
result = sum(map(hash, instructions))

print(result)

boxes = [dict() for _ in range(256)]

for step in instructions:
    match step.strip("-").split("="):
        case [l, f]:
            boxes[hash(l)][l] = int(f)
        case [l]:
            boxes[hash(l)].pop(l, 0)

print(
    sum(i * j * f for i, b in enumerate(boxes, 1) for j, f in enumerate(b.values(), 1))
)
