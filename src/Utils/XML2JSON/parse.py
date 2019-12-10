import json
import os,sys,inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)
import parse_merge

def xml_to_json(enfile="strings.xml", myfile="strings.xml", khfile="strings.xml", version = "1.0.0", output= "output.json"):
    doc = parse_merge.read_file(enfile)
    en_json = parse_merge.language_dict(doc['resources']['string'])

    doc = parse_merge.read_file(myfile)
    my_json = parse_merge.language_dict(doc['resources']['string'])

    doc = parse_merge.read_file(khfile)
    kh_json = parse_merge.language_dict(doc['resources']['string'])

    data = {"en": en_json, "my": my_json, "kh": kh_json}
    dict = {}
    dict["version"] = version
    dict["data"] = data
    parse_merge.write_string_to_file(json.dumps(dict), output)

if __name__ == '__main__':
    # enfile = "https://raw.githubusercontent.com/xuanloct4/HoTMobile/master/package.json"
    # myfile = "https://raw.githubusercontent.com/xuanloct4/HoTMobile/master/package.json"
    # khfile = "https://raw.githubusercontent.com/xuanloct4/HoTMobile/master/package.json"

    enfile = "file:en_strings.xml"
    myfile = "file:///Library/WebServer/Documents/hot/src/en_strings.xml"
    khfile = "file:///Library/WebServer/Documents/hot/src/en_strings.xml"

    version = "1.0.0"
    output = "output.json"

    if len(sys.argv) == 6:
        enfile = sys.argv[1]
        myfile = sys.argv[2]
        khfile = sys.argv[3]
        version = sys.argv[4]
        output = sys.argv[5]
    elif len(sys.argv) == 5:
        enfile = sys.argv[1]
        myfile = sys.argv[2]
        version= sys.argv[3]
        output = sys.argv[4]
    elif len(sys.argv) == 4:
        enfile = sys.argv[1]
        version= sys.argv[2]
        output = sys.argv[3]
    elif len(sys.argv) == 3:
        version= sys.argv[1]
        output = sys.argv[2]

    print("Usage: python script.py <en_xml> <my_xml> <kh_xml> <version> <output>")

    xml_to_json(enfile, myfile, khfile, version, output)

