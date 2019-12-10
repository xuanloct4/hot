import json
import os,sys,inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)
import parse_merge

def dict_by_add_suffix(dict):
    suff_dict = {}
    for key in dict:
        suff_dict[key] = dict[key] +  " BE"
    return suff_dict

if __name__ == '__main__':
    output = "output.json"

    print("Usage: python script.py <output file> <version> <file1> <file2> <file3> ....")
    if len(sys.argv) < 4:
        exit(0);

    output = sys.argv[1]
    version = sys.argv[2]

    en = {}
    kh = {}
    my = {}
    for i in range(3, len(sys.argv)):
        dict = parse_merge.read_file(sys.argv[i])
        en.update(dict['data']['en'])
        # kh.update(dict['data']['kh'])
        my.update(dict['data']['my'])

    en = dict_by_add_suffix(en)
    my = dict_by_add_suffix(my)
    kh = dict_by_add_suffix(kh)

    dict = {}
    dict["version"] = version
    dict["data"] = {"en": en, "kh": kh, "my": my}
    parse_merge.write_string_to_file(json.dumps(dict), output)
