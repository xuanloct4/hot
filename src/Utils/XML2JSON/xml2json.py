#!/usr/bin/python3
import json
import sys
import xml.etree.ElementTree


def read_file(filename):
    print(xml.etree.ElementTree.parse(filename));
    root = xml.etree.ElementTree.parse(filename).getroot()
    return root


# assule we have a list of <quiz>, contained in some other element
def parse_quiz(quiz_element, out):
    i = 1
    tmp = {}
    for child in quiz_element:

        name, value = child.tag, child.text
        if name == 'que':
            name = 'question'
        else:
            name = 'answer%s' % i
            i += 1
        tmp[name] = value
    out.append(tmp)


def parse_root(root_element, out):
    for child in root_element:
        if child.tag == 'quiz':
            parse_quiz(child, out)


def convert_xml_to_json(filename):
    root = read_file(filename)
    print("File :");
    print(filename);
    out = []
    parse_root(root, out)
    print(json.dumps(out))


if __name__ == '__main__':
    if len(sys.argv) > 1:
        convert_xml_to_json(sys.argv[1])
    else:
        print("Usage: script <filename_with_xml>")
