import { Button } from "@/Components/ui/button";
import {
    Field,
    FieldError,
    FieldGroup,
    FieldLabel,
    FieldLegend,
    FieldSet,
} from "@/Components/ui/field";
import { Input } from "@/Components/ui/input";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { useForm } from "@inertiajs/react";
import React, { useState } from "react";

export default function Create({ mahasiswa, dosen, matakuliah }) {
    const [mahasiswaApi, setMahasiswaApi] = useState(mahasiswa || []);
    const [dosenApi, setDosenApi] = useState(dosen || []);
    const [mataKuliahApi, setMataKuliahApi] = useState(matakuliah || []);

    const { data, setData, post, processing, errors } = useForm({
        mahasiswa_id: "",
        dosen_id: "",
        matakuliah_id: "",
        nilai_angka: "",
        nilai_huruf: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("nilai.store"));
    };

    const resetSubmit = () => {
        setData({
            mahasiswa_id: "",
            dosen_id: "",
            matakuliah_id: "",
            nilai_angka: "",
            nilai_huruf: "",
        });
    };
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <FieldSet>
                    <FieldLegend>Tambah Nilai</FieldLegend>
                    <FieldGroup>
                        <Field>
                            <FieldLabel htmlFor="name">Mahasiswa</FieldLabel>
                            <Select
                                value={data.mahasiswa_id.toString()}
                                onValueChange={(val) => {
                                    setData("mahasiswa_id", val);
                                }}
                            >
                                <SelectTrigger id="name">
                                    <SelectValue placeholder="nama mahasiswa">
                                        {
                                            mahasiswaApi.find(
                                                (m) =>
                                                    m.id.toString() ===
                                                    data.mahasiswa_id.toString()
                                            )?.nama
                                        }
                                    </SelectValue>
                                </SelectTrigger>
                                <SelectContent>
                                    {mahasiswaApi &&
                                        mahasiswaApi.map((item, index) => {
                                            return (
                                                <SelectItem
                                                    value={item.id}
                                                    key={index}
                                                >
                                                    {item.nama}
                                                </SelectItem>
                                            );
                                        })}
                                </SelectContent>
                            </Select>
                            {errors.mahasiswa_id && (
                                <FieldError>{errors.mahasiswa_id}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="dosen">Dosen</FieldLabel>
                            <Select
                                value={data.dosen_id.toString()}
                                onValueChange={(val) => {
                                    setData("dosen_id", val);
                                }}
                            >
                                <SelectTrigger id="dosen">
                                    <SelectValue placeholder="nama dosen">
                                        {
                                            dosenApi.find(
                                                (m) =>
                                                    m.id.toString() ===
                                                    data.dosen_id.toString()
                                            )?.nama
                                        }
                                    </SelectValue>
                                </SelectTrigger>
                                <SelectContent>
                                    {dosenApi &&
                                        dosenApi.map((item, index) => {
                                            return (
                                                <SelectItem
                                                    value={item.id}
                                                    key={index}
                                                >
                                                    {item.nama}
                                                </SelectItem>
                                            );
                                        })}
                                </SelectContent>
                            </Select>
                            {errors.dosen_id && (
                                <FieldError>{errors.dosen_id}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="mk">Mata Kuliah</FieldLabel>
                            <Select
                                value={data.matakuliah_id.toString()}
                                onValueChange={(val) => {
                                    setData("matakuliah_id", val);
                                }}
                            >
                                <SelectTrigger id="mk">
                                    <SelectValue placeholder="nama mata kuliah">
                                        {
                                            mataKuliahApi.find(
                                                (m) =>
                                                    m.id.toString() ===
                                                    data.matakuliah_id.toString()
                                            )?.nama
                                        }
                                    </SelectValue>
                                </SelectTrigger>
                                <SelectContent>
                                    {mataKuliahApi &&
                                        mataKuliahApi.map((item, index) => {
                                            return (
                                                <SelectItem
                                                    value={item.id}
                                                    key={index}
                                                >
                                                    {item.nama}
                                                </SelectItem>
                                            );
                                        })}
                                </SelectContent>
                            </Select>
                            {errors.matakuliah_id && (
                                <FieldError>{errors.matakuliah_id}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="nh">Nilai Huruf</FieldLabel>
                            <Input
                                id="nh"
                                autoComplete="off"
                                aria-invalid
                                value={data.nilai_huruf}
                                onChange={(e) =>
                                    setData("nilai_huruf", e.target.value)
                                }
                            />
                            {errors.nilai_huruf && (
                                <FieldError>{errors.nilai_huruf}</FieldError>
                            )}
                        </Field>
                        <Field>
                            <FieldLabel htmlFor="nh">Nilai Angka</FieldLabel>
                            <Input
                                id="nh"
                                type="number"
                                autoComplete="off"
                                aria-invalid
                                value={data.nilai_angka}
                                onChange={(e) =>
                                    setData("nilai_angka", e.target.value)
                                }
                            />
                            {errors.nilai_angka && (
                                <FieldError>{errors.nilai_angka}</FieldError>
                            )}
                        </Field>
                        <Button type="button" onClick={resetSubmit}>
                            Reset
                        </Button>
                        <Button type="submit">Tambah</Button>
                    </FieldGroup>
                </FieldSet>
            </form>
        </div>
    );
}
