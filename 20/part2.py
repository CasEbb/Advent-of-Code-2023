# Input: lines like "<stuff> -> <other stuff>"
#        <stuff> starts with %: initially off, low and off -> on and sends high, low and on -> off and low
#                            &: initially remember each input as low, receives -> all high -> low, else high
#                "broadcaster" sends input to all outputs in order
#        evaluate breadth-first
# Output: how many times must you send low to "broadcaster" before "rx" receives a low pulse?

rules = {}
button_count = 0

file = open("input", "r")
for line in file:
    line = line.replace("\n", "")
    if line == "":
        continue
    prefix, suffix = line.split(" -> ")
    if prefix == "broadcaster":
        type = ""
        module = prefix
    else:
        type = prefix[0]
        module = prefix[1:]
    self_state = "off"  # only relevant for "%"
    input_states = {}  # only relevant for "&"
    rules[module] = [type, suffix.split(", "), self_state, input_states]

for module in rules:
    for target in rules[module][1]:
        if target in rules:
            rules[target][3][module] = "low"

finished = False
while not finished:
    inputs = [["button", "broadcaster", "low"]]
    button_count += 1
    while len(inputs) > 0:
        input = inputs[0]
        inputs = inputs[1:]
        source, module, level = input[0], input[1], input[2]
        if module == "rx" and level == "low":
            finished = True
            break
        if not (module in rules):
            continue
        if module == "broadcaster":
            for target in rules[module][1]:
                inputs.append([module, target, level])
            continue
        if rules[module][0] == "%" and level == "low":
            if rules[module][2] == "off":
                rules[module][2] = "on"
                for target in rules[module][1]:
                    inputs.append([module, target, "high"])
            else:
                rules[module][2] = "off"
                for target in rules[module][1]:
                    inputs.append([module, target, "low"])
        if rules[module][0] == "&":
            rules[module][3][source] = level
            if "low" in rules[module][3].values():
                new_level = "high"
            else:
                new_level = "low"
            # in your case, the endpoints are &(these) -> &gh -> rx
            if module in ["rk", "cd", "zf", "qx"] and new_level == "high":
                print("Debug", button_count, "/", module, "/", new_level)
            # and the results are 3733 rk, 3793 cd, 3947 zf, 4057 qx
            # so the answer is lcm(those values)
            for target in rules[module][1]:
                inputs.append([module, target, new_level])

print(button_count)
